<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

class Command
{
    private $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function __toString(): string
    {
        return $this->command;
    }
}
