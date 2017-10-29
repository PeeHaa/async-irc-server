<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

class Parameter
{
    private $parameter;

    public function __construct(string $parameter)
    {
        $this->parameter = $parameter;
    }

    public function __toString(): string
    {
        return $this->parameter;
    }
}
