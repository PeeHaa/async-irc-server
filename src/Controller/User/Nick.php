<?php declare(strict_types=1);

namespace AsyncIrcServer\Controller\User;

use Amp\Promise;
use AsyncIrcServer\Command\Request\Nick as Request;
use AsyncIrcServer\Command\Response\Error\ErroneusNickname;
use AsyncIrcServer\Command\Response\Error\NicknameInUse;
use AsyncIrcServer\Command\Response\Error\NoNicknameGiven;
use AsyncIrcServer\Command\Response\Reply\Nick as Response;
use AsyncIrcServer\Message\Parameter;
use AsyncIrcServer\Message\Parameters;
use AsyncIrcServer\Message\Prefix;
use AsyncIrcServer\Message\Trailer;
use AsyncIrcServer\Storage\User as UserStorage;
use function Amp\call;

class Nick
{
    public function process(Request $request, UserStorage $userStorage): Promise
    {
        return call(function() use ($request, $userStorage) {
            if (!$request->hasNick()) {
                return new NoNicknameGiven(new Prefix('foobar'));
            }

            // @todo use proper grammar rules https://tools.ietf.org/html/rfc2812#section-2.3.1
            if (!preg_match('~^[a-z][a-z0-9\-]{0,8}$~i', $request->getNick())) {
                return new ErroneusNickname(new Prefix('foobar'), new Parameter($request->getNick()));
            }

            if (yield $userStorage->exists($request->getNick())) {
                return new NicknameInUse(new Prefix('foobar'), new Parameter($request->getNick()));
            }

            // @todo check other servers in the network for nick collisions and throw a ERR_NICKCOLLISION when needed

            // @todo add other checks

            return new Response(
                new Prefix('foobar'),
                new Parameters(
                    new Parameter($request->getNick()),
                    new Trailer(sprintf('Welcome to the Internet Relay Chat Network %s', $request->getNick()))
                )
            );
        });
    }
}
