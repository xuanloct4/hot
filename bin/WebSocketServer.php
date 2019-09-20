<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Src\WebSocket\WebSocket;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocket()
        )
    ),
    8080
);
$server->run();


// //On the web, paste the code below to Console to test the ws connection
// var conn = new WebSocket('ws://localhost:8080');
// conn.onopen = function(e) {
//     console.log("Connection established!");
// };
//
// conn.onmessage = function(e) {
//     console.log(e.data);
// };
//
// conn.send('Hello World!');