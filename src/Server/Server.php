<?php declare(strict_types=1);

namespace AsyncIrcServer\Server;

use Amp\ByteStream\Message;
use Amp\Process\Process;
use Amp\Promise;
use Amp\Socket\ServerSocket;
use Amp\Success;
use AsyncIrcServer\Command\Response\Notice;
use AsyncIrcServer\Message\Parameter;
use AsyncIrcServer\Message\Parameters;
use AsyncIrcServer\Message\Prefix;
use AsyncIrcServer\Message\Trailer;
use AsyncIrcServer\Router\FrontController;
use function Amp\call;
use function Amp\asyncCall;
use function Amp\Socket\listen;

class Server
{
    private $clients = [];

    private $uri;

    private $frontController;

    private $name;

    public function __construct(Uri $uri, FrontController $frontController, string $name)
    {
        $this->uri             = $uri;;
        $this->frontController = $frontController;
        $this->name            = $name;
    }

    public function listen()
    {
        $socket = listen((string) $this->uri);

        while ($client = yield $socket->accept()) {
            $this->handleClient($client);
        }
    }

    private function handleClient(ServerSocket $socket)
    {
        asyncCall(function() use ($socket) {
            $remoteAddress = $socket->getRemoteAddress();

            yield $this->registerClient($socket);

            $buffer = '';

            while (null !== $chunk = yield $socket->read()) {
                $buffer .= $chunk;

                while (($pos = strpos($buffer, "\r\n")) !== false) {
                    yield $this->handleMessage($socket, substr($buffer, 0, $pos));

                    $buffer = substr($buffer, $pos + 2);
                }
            }

            unset($this->clients[$remoteAddress]);
        });
    }

    private function registerClient(ServerSocket $socket): Promise
    {
        return call(function() use ($socket) {
            $response = new Notice(
                new Prefix($this->name),
                new Parameters(new Parameter('*'), new Trailer('*** Looking up your hostname'))
            );

            $socket->write($response . "\r\n");

            preg_match('~^(.*):\d+$~', $socket->getRemoteAddress(), $matches);

            $process = new Process('nslookup ' . $matches[1]);

            $process->start();

            $result = yield new Message($process->getStdout());

            if (!preg_match('~^Name:\s+(.*)$~m', $result, $matches)) {
                $response = new Notice(
                    new Prefix($this->name),
                    new Parameters(new Parameter('*'), new Trailer('*** Couldn\'t find your hostname. Closing connection...'))
                );

                $socket->end($response . "\r\n");

                return;
            }

            $this->clients[$socket->getRemoteAddress()] = $socket;

            $response = new Notice(
                new Prefix($this->name),
                new Parameters(new Parameter('*'), new Trailer('*** Found your hostname (' . $matches[1] . ').'))
            );

            $socket->write($response . "\r\n");
        });
    }

    function handleMessage(ServerSocket $socket, string $message): Promise
    {
        if ($message === '') {
            return new Success();
        }

        return call(function() use ($socket, $message) {
            $response = yield $this->frontController->run($message);

            if (!$response) {
                return;
            }

            return $socket->write($response . "\r\n");
        });
    }
}
