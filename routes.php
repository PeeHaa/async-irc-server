<?php declare(strict_types=1);

namespace AsyncIrcServer;

use AsyncIrcServer\Command\Request\Nick as NickRequest;
use AsyncIrcServer\Controller\User\Nick as NickController;
use AsyncIrcServer\Router\Router;
use Auryn\Injector;

/** @var Injector $auryn*/
$router = $auryn->make(Router::class);

$router
    ->addRoute(NickRequest::COMMAND, NickRequest::class, [NickController::class, 'process'])
;
