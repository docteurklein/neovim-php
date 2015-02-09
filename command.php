<?php

require __DIR__.'/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$socket = stream_socket_client(getenv('NVIM_LISTEN_ADDRESS'), $errno, $errstr);
$stream = new React\Stream\Stream($socket, $loop);

$client = new Nvim\Client($stream);

$client->{$argv[1]}(@$argv[2]);

$loop->tick();
