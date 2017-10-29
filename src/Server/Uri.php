<?php declare(strict_types=1);

namespace AsyncIrcServer\Server;

class Uri
{
    private $address;

    private $port;

    public function __construct(string $address, int $port)
    {
        $this->address = $address;
        $this->port    = $port;
    }

    public function __toString(): string
    {
        return sprintf('tcp://%s:%d', $this->address, $this->port);
    }
}
