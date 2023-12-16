<?php

namespace CFGit\TwigEngine\Extensions;

use \Twig\Error\SyntaxError;
use \Twig\Token;
use \Twig\TokenParser\AbstractTokenParser;

class OnceTokenParser extends AbstractTokenParser
{
    protected bool $debug = false;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function parse(Token $token): OnceNode
    {
        $stream = $this->parser->getStream();
        try {
            $name = $stream->expect(Token::NAME_TYPE)->getValue();
        } catch (SyntaxError $e) {
            $name = null;
        }
        $stream->expect(Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideEnd'], true);
        if (is_null($name)) $name = md5($body);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new OnceNode($name, $body, $token->getLine(), $this->getTag(), $this->debug);
    }

    public function decideEnd(Token $token): bool
    {
        return $token->test('endonce');
    }

    public function getTag(): string
    {
        return 'once';
    }
}