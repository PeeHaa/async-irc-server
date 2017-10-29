<?php declare(strict_types=1);

namespace AsyncIrcServer\Command\Response\Error;

use AsyncIrcServer\Message\Parameter;
use AsyncIrcServer\Message\Prefix;

class ErroneusNickname
{
    private const NUMERIC = 432;

    private $prefix;

    private $nick;

    public function __construct(Prefix $prefix, Parameter $nick)
    {
        $this->prefix = $prefix;
        $this->nick   = $nick;
    }

    public function __toString(): string
    {
        return sprintf(':%s %s %s :Erroneus nickname', self::NUMERIC, $this->prefix, $this->nick);
    }
}
