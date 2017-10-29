<?php declare(strict_types=1);

namespace AsyncIrcServer\Command\Request;

use AsyncIrcServer\Message\Message;

class Nick
{
    public const COMMAND = 'NICK';

    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function hasNick(): bool
    {
        return $this->message->hasParameters();
    }
}
