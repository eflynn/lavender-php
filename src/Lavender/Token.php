<?php

namespace Lavender;

interface Token
{
    const ITEM_INDENT = 1;
    const ITEM_IDENTIFIER = 2;
    const ITEM_CHAR = 3;
    const ITEM_EOF = 4;
    const ITEM_KEYWORD = 100;
    const ITEM_IF = 101;
    const ITEM_ELSE = 102;
    const ITEM_BLOCK = 103;
    const ITEM_EXTENDS = 104;
    const ITEM_EACH = 105;
    const ITEM_INCLUDE = 106;
    const ITEM_IN = 107;
    const ITEM_COLLECTION = 108;
    const ITEM_DOCTYPE = 109;
}