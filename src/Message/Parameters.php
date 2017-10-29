<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

class Parameters implements \Countable
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

    public function get(int $index): string
    {
        return (string) $this->parameters[$index];
    }

    public function count(): int
    {
        return count($this->parameters);
    }
}
