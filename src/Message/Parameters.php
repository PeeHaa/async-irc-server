<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

class Parameters
{
    private $parameters = [];

    public function __construct(Parameter ...$parameters)
    {
        $this->parameters = $parameters;
    }

    public function __toString(): string
    {
        return implode(' ', $this->parameters);
    }
}
