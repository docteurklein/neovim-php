<?php

require __DIR__.'/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$socket = stream_socket_client(getenv('NVIM_LISTEN_ADDRESS'), $errno, $errstr);
$stream = new React\Stream\Stream($socket, $loop);

$client = new Nvim\Client($stream);

$client->subscribe($argv[1], 'var_dump');

$loop->run();
