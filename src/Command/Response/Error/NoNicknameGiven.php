<?php declare(strict_types=1);

namespace AsyncIrcServer\Command\Response\Error;

use AsyncIrcServer\Message\Prefix;

class NoNicknameGiven
{
    private const NUMERIC = 431;

    private $prefix;

    public function __construct(Prefix $prefix)
    {
        $this->prefix = $prefix;
    }

    public function __toString(): string
    {
        return sprintf(':%s %s :No nickname given', self::NUMERIC, $this->prefix);
    }
}
