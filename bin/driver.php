<?php

use Lavender\InputStream;
use Lavender\Tokenizer;
use Lavender\Token;

chdir(dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';

function parse($txt)
{
    $is = new InputStream($txt);
    $tokenizer = new Tokenizer();
    $tokens = $tokenizer->tokenize($is);

    print_r($tokens);
}

parse(file_get_contents('tests/test.jade'));

