<?php

namespace Nvim\Php;

use Nvim\Php\Complete\Context;

class Complete
{

    public function __construct()
    {
    }

    public function complete(Context $context)
    {
        $tokens = iterator_to_array($this->atLine($context));
        $subject = $this->getSubject($tokens, $context);
    }

    private function getSubject(array $tokens, Context $context)
    {
        foreach ($tokens as $token) {
        }
    }

    private function lookup($variable)
    {

    }

    private function atLine(Context $context)
    {
        $line = $context->getPosition()->line;
        foreach (token_get_all($context->getContent()->content) as $token) {
            if (!is_array($token)) {
                continue;
            }
            if ($token[2] !== $line) {
                continue;
            }
            if (empty(trim($token[1]))) {
                continue;
            }

            yield new Token(token_name($token[0]), $token[1]);
        }
    }

    public function tmp(Context $context)
    {
        $stream = new \PHP_Token_Stream($context->getContent()->content);
        foreach ($stream->getFunctions() as $class) {
            var_dump($class['arguments']);
        }
        foreach ($stream->getClasses() as $class) {
            var_dump($class['methods']);
        }

    }
}

class Token
{
    public $name;
    public $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

}
