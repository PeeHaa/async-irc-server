<?php declare(strict_types=1);

namespace AsyncIrcServer\Router;

use Amp\Promise;
use Amp\Success;
use AsyncIrcServer\Message\Factory;
use Auryn\Injector;

class FrontController
{
    private $auryn;

    private $router;

    private $messageFactory;

    public function __construct(Injector $auryn, Router $router, Factory $messageFactory)
    {
        $this->auryn          = $auryn;
        $this->router         = $router;
        $this->messageFactory = $messageFactory;
    }

    public function run(string $message): Promise
    {
        $message = $this->messageFactory->build($message);

        if (!$this->router->exists($message->getCommand())) {
            var_dump('unknown route: ' . $message->getCommand());
            return new Success();
        }

        var_dump('known route: ' . $message->getCommand());

        // @todo fine a nicer way to share the object for just the scope of the Injector::execute() call
        $this->auryn->share($message);

        return $this->auryn->execute($this->router->getAction($message->getCommand()));
    }
}
