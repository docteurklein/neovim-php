<?php

namespace Nvim\Php\Complete;

class Position
{
    public $line;
    public $col;

    public function __construct($line, $col)
    {
        $this->line = $line;
        $this->col = $col;
    }
}
