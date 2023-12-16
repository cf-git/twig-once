<?php

namespace CFGit\TwigEngine\Extensions\Once;

use Twig\Compiler;
use Twig\Node\Node;

class OnceNode extends Node
{
    protected bool $debug = false;
    protected static array $printed = [];

    public static function canPrint($key): bool
    {
        $result = !isset(static::$printed[$key]);
        static::put($key);
        return $result;
    }

    public static function put($key): bool
    {
        return static::$printed[$key] = true;
    }

    public function __construct($name, $value, $line, $tag, bool $debug = false)
    {
        parent::__construct(['value' => $value], ['name' => $name], $line, $tag);
    }

    public function compile(Compiler $compiler): void
    {
        $compiler->addDebugInfo($this);
        $name = $this->getAttribute('name');

        $container = static::class;

        $compiler->raw("if ({$container}::canPrint('{$name}')) {\n");
        if ($this->debug) {
            $compiler->raw("print \"<!-- Begin Once {$name} -->\";\n");
        }
        $compiler->subcompile($this->getNode('value'))->raw(";\n");
        if ($this->debug) {
            $compiler->raw(
                "print \"<!-- End Once {$name} -->\";\n"
                . "} else {\n"
                . "print \"<!-- Already printed {$name} -->\";\n"
            );
        }
        $compiler->raw("}\n");
    }
}