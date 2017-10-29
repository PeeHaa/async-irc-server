<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

class Trailer extends Parameter
{
    public function __toString(): string
    {
        return ':' . $this->parameter;
    }
}
