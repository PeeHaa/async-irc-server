<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

class Message
{
    private $prefix;

    private $command;

    private $parameters;

    public function __construct(Command $command, Parameters $parameters, Prefix $prefix = null)
    {
        $this->prefix     = $prefix;
        $this->command    = $command;
        $this->parameters = $parameters;
    }

    public function getCommand(): string
    {
        return (string) $this->command;
    }

    public function hasParameters(): bool
    {
        return (bool) count($this->parameters);
    }

    public function getParameter(int $index): string
    {
        return $this->parameters->get($index);
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->command, $this->parameters);
    }
}
