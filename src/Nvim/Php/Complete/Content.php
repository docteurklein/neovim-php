<?php

namespace Nvim\Php\Complete;

class Content
{
    public $line;
    public $content;
    public $word;

    public function __construct($content, $line, $word)
    {
        $this->content = $content;
        $this->line = $line;
        $this->word = $word;
    }

}
