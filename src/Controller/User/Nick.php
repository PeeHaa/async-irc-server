<?php declare(strict_types=1);

namespace AsyncIrcServer\Controller\User;

use Amp\Promise;
use Amp\Success;
use AsyncIrcServer\Command\Request\Nick as Request;
use AsyncIrcServer\Command\Response\Nick as Response;
use AsyncIrcServer\Message\Parameter;
use AsyncIrcServer\Message\Parameters;
use AsyncIrcServer\Message\Prefix;
use AsyncIrcServer\Message\Trailer;

class Nick
{
    public function process(Request $request): Promise
    {
        if (!$request->hasNick()) {

        }

        var_dump($request);

        $response = new Response(
            new Prefix('foobar'),
            new Parameters(
                new Parameter('Nickname'),
                new Trailer(sprintf('Welcome to the %s %s', 'Nickname'))
            )
        );

        return new Success();
    }
}
