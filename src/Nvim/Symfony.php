<?php

namespace Nvim;

use Nvim\Php\Complete;
use Nvim\Php\Complete\Position;
use Nvim\Php\Complete\Context;
use Nvim\Php\Complete\Content;

class Symfony
{
    private $client;
    private $completer;

    public function __construct(Client $client, Complete $completer)
    {
        $this->completer = $completer;
        $this->client = $client;
        $this->client->command('augroup! symfony');
        $this->client->command('augroup symfony');
        $this->client->command('au!');
        $this->client->subscribe(['TextChangedI'], [$this, 'textChanged'], [
            'getline(line("."))',
            'line(".")',
            'col(".")',
            'virtcol(".")',
            'expand("<cword>")',
            'expand("%:p")',
            'join(getline(1, "$"), "\n")',
        ]);
        $this->client->command('augroup symfony END');
    }

    public function textChanged(array $arguments)
    {
        $this->completer->complete(Context::fromPositionIn(
            new Position($arguments['line(".")'], $arguments['virtcol(".")']),
            new Content(
                $arguments['join(getline(1, "$"), "\n")'],
                $arguments['getline(line("."))'],
                $arguments['expand("<cword>")']
            )
        ));
    }
}
