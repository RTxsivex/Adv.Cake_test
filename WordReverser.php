<?php

namespace TestTask;

class WordReverser
{
    public static function reverse(string $text): string
    {
        
        $tokens = preg_split('/(\s+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        return implode('', array_map([self::class, 'processToken'], $tokens));
    }

    private static function processToken(string $token): string
    {
        if (trim($token) === '') {
            return $token;
        }

        return preg_replace_callback('/\p{L}+/u', [self::class, 'reverseWord'], $token);
    }

    private static function reverseWord(array $match): string
    {
        $word = $match[0];
        $chars = mb_str_split($word, 1, 'UTF-8');
        
        $upperPositions = [];
        foreach ($chars as $i => $char) {
            if (self::isUpperCase($char)) {
                $upperPositions[] = $i;
            }
        }
        
        
        $lowerChars = array_map(function($char) {
            return mb_strtolower($char, 'UTF-8');
        }, $chars);
        
        $reversed = array_reverse($lowerChars);
        
        
        $result = '';
        foreach ($reversed as $i => $char) {
            
            if (in_array($i, $upperPositions)) {
                $result .= mb_strtoupper($char, 'UTF-8');
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    private static function isUpperCase(string $ch): bool
    {
        if (!preg_match('/\p{L}/u', $ch)) {
            return false;
        }
        return $ch === mb_strtoupper($ch, 'UTF-8');
    }
}