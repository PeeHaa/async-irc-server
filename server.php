#!/usr/bin/env php
<?php declare(strict_types=1);

namespace AsyncIrcServer;

use Amp\Loop;
use Amp\Redis\Client as RedisClient;
use AsyncIrcServer\Router\FrontController;
use AsyncIrcServer\Router\Router;
use AsyncIrcServer\Server\Server;
use AsyncIrcServer\Server\Uri;
use Auryn\Injector;

require_once __DIR__ . '/vendor/autoload.php';

$auryn = new Injector();

$auryn->share($auryn);

$auryn->share(RedisClient::class);
$auryn->define(RedisClient::class, [
    ':uri' => 'tcp://localhost:6379',
]);

$auryn->define(Uri::class, [
    ':address' => '127.0.0.1',
    ':port'    => 6667,
]);

$auryn->share(Router::class);

require_once __DIR__ . '/routes.php';

$auryn->share(FrontController::class);

$server = $auryn->make(Server::class, [
    ':name' => 'irc.pieterhordijk.com',
]);

Loop::run(function() use ($server) {
    yield from $server->listen();
});
