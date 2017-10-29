<?php declare(strict_types=1);

namespace AsyncIrcServer\Storage;

use Amp\Promise;
use Amp\Redis\Client;

class User
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function exists(string $nick): Promise
    {
        return $this->client->exists('user_' . $nick);
    }
}
