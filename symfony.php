<?php

use PhpParser\ParserFactory;
use TokenReflection\Broker;

require __DIR__.'/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$socket = stream_socket_client(getenv('NVIM_LISTEN_ADDRESS'), $errno, $errstr);
$stream = new React\Stream\Stream($socket, $loop);

(new Nvim\Symfony(
    new Nvim\Client($stream),
    new Nvim\Php\Complete(
        (new ParserFactory)->create(ParserFactory::PREFER_PHP7, null, [
            'throwOnError' => false,
        ]),
        new Broker(new Broker\Backend\Memory)
    )
));

$loop->run();

