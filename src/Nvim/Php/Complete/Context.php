<?php

namespace Nvim\Php\Complete;

use Nvim\Php\Complete\Position;
use Nvim\Php\Complete\Content;

class Context
{
    private $position;
    private $content;

    private function __construct(Position $position, Content $content)
    {
        $this->position = $position;
        $this->content = $content;
    }

    public static function fromPositionIn(Position $position, Content $content)
    {
        return new self($position, $content);
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getContent()
    {
        return $this->content;
    }
}
