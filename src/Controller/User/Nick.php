<?php declare(strict_types=1);

namespace AsyncIrcServer\Controller\User;

use Amp\Promise;
use Amp\Success;
use AsyncIrcServer\Command\Request\Nick as Request;

class Nick
{
    public function process(Request $request): Promise
    {
        return new Success();
    }
}
