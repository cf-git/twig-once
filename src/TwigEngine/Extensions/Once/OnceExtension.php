<?php
namespace CFGit\TwigEngine\Extensions\Once;

use \Twig\Extension\AbstractExtension;

class OnceExtension extends AbstractExtension
{
    protected $debug;

    public function __construct($debug = false)
    {
        $this->debug = $debug;
    }

    public function getTokenParsers()
    {
        return [
            new OnceTokenParser($this->debug)
        ];
    }
}