<?php

// >composer dump-autoload - to generate autoload declared in composer.json
// the purpose of autoload is that any file included in that directory with the namespace will be automatically included, no need to require.

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Socket;


require dirname( __FILE__ ) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Socket()
        )
    ),
    8080
);

echo "Server started at port 8080\n";
$server->run();
