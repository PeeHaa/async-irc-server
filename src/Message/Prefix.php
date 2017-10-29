<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

class Prefix
{
    private $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function __toString(): string
    {
        return $this->prefix;
    }
}
