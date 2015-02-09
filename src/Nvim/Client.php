<?php

namespace Nvim;

use React\Stream\Stream;
use React\Promise\Deferred;

class Client
{
    private $stream;
    private $unpacker;
    private $counter = 1;
    private $subscriptions = [];
    private $commands = [];

    public function __construct(Stream $stream, \MessagePackUnpacker $unpacker = null)
    {
        $this->stream = $stream;
        $this->unpacker = $unpacker ?: new \MessagePackUnpacker;
        $this->stream->on('data', function($data) {
            $this->unpacker->feed($data);
            while ($this->unpacker->execute()) {
                $msg = $this->unpacker->data();
                $this->unpacker->reset();
                $this->forward($msg);
            }
        });
    }

    public function __call($method, array $arguments = [])
    {
        return $this->send($method, $arguments);
    }

    public function subscribe(array $events, callable $callable, array $args = [])
    {
        foreach ($events as $event) {
            $this->command(vsprintf('au %s * call rpcnotify(0, "%s", %s)', [
                $event,
                $event,
                implode(', ', $args),
            ]));
            $this->send('vim_subscribe', [$event]);
            $this->subscriptions[$event][] = [$callable, $args];
        }
    }

    public function command($command)
    {
        return $this->send('vim_command', [$command]);
    }

    private function forward(array $msg)
    {
        if (isset($this->subscriptions[$msg[1]])) {
            foreach ($this->subscriptions[$msg[1]] as $callback) {
                call_user_func($callback[0], array_combine($callback[1], $msg[2]));
            }
        }
        if (isset($this->commands[$msg[1]])) {
            $this->commands[$msg[1]]->resolve($msg);
            unset($this->commands[$msg[1]]);
        }
    }

    private function send($function, array $arguments = [])
    {
        $id = $this->counter++;
        $bin = msgpack_pack([0, $id, $function, $arguments]);
        $this->stream->write($bin);

        $deferred = new Deferred;
        $this->commands[$id] = $deferred;

        return $deferred->promise();
    }
}
