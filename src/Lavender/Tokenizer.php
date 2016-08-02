<?php

namespace Lavender;

class Tokenizer
{
    private $indentStack = array(0);
    private $tokenStack;

    private static $keywordMap = array(
        'if'            => Token::ITEM_IF,
        'else'          => Token::ITEM_ELSE,
        'block'         => Token::ITEM_BLOCK,
        'extends'       => Token::ITEM_EXTENDS,
        'each'          => Token::ITEM_EACH,
        'include'       => Token::ITEM_INCLUDE,
        'in'            => Token::ITEM_IN,
        'collection'    => Token::ITEM_COLLECTION,
        'doctype'       => Token::ITEM_DOCTYPE,
    );

    /**
     * Tokenizer constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $input
     * @return array
     */
    public function tokenize(InputStream $input)
    {
        $this->indentStack = array(0);
        $this->tokenStack = array();

        $this->state = 'lexBol';

        while($this->state !== null) {
            $this->state = $this->{$this->state}($input);
        }

        return $this->tokenStack;
    }

    /**
     * @param $type
     * @param null $lexeme
     */
    private function emit($type, $lexeme = null)
    {
        $token = new \stdClass();
        $token->type = $type;

        if (isset($lexeme)) {
            $token->lexeme = $lexeme;
        }
        
        $this->tokenStack[] = $token;
    }

    /**
     * @param $chr
     */
    private function emitChar($chr)
    {
        $this->tokenStack[] = $chr;
    }

    /**
     * @param $input
     * @return string
     */
    private function lexBol(InputStream $input)
    {
        if ($input->accept(' ')) {
            $input->acceptRun(' ');

            $spaces = $input->emit();
            $this->indentStack[] = strlen($spaces);
            $this->emit(Token::ITEM_INDENT, $spaces);
        }

        return 'lexLine';
    }

    /**
     * @param $input
     * @return null
     */
    private function lexLine($input)
    {
        /*
         * $re = '/\G(?:[\.]|(?:\#[_a-z0-9-]|-?[_a-z])
         * [_a-z0-9-]*)/ix';
         */

        if ($input->accept('.')) {
            $this->emitChar($input->emit());
        }

        while (true) {
            $r = $input->peek();

            if (ctype_alnum($r) || $r == '_') {
                $input->next();
            } elseif (!isset(self::$keywordMap[$input->get()])) {
                $this->emit(Token::ITEM_IDENTIFIER, $input->emit());
                break;
            } else {
                $this->emit(self::$keywordMap[$input->get()], $input->emit());
                break;
            }
        }

        $this->emit(Token::ITEM_EOF);

        return null;
    }
}
