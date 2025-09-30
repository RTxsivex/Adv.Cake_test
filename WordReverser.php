<?php

namespace TestTask;

class WordReverser
{
    public static function reverse(string $text): string
    {
        // Разбиваем на токены (слова + пробелы)
        $tokens = preg_split('/(\s+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        return implode('', array_map([self::class, 'processToken'], $tokens));
    }

    private static function processToken(string $token): string
    {
        if (trim($token) === '') {
            return $token;
        }

        // В токене переворачиваем каждую буквенную последовательность отдельно
        return preg_replace_callback('/\p{L}+/u', [self::class, 'reverseWord'], $token);
    }

    private static function reverseWord(array $match): string
    {
        $word = $match[0];
        $chars = mb_str_split($word, 1, 'UTF-8');
        
        // ЗАПОМИНАЕМ: какие позиции были в верхнем регистре
        $upperPositions = [];
        foreach ($chars as $i => $char) {
            if (self::isUpperCase($char)) {
                $upperPositions[] = $i;
            }
        }
        
        // Переворачиваем все буквы в нижнем регистре
        $lowerChars = array_map(function($char) {
            return mb_strtolower($char, 'UTF-8');
        }, $chars);
        
        $reversed = array_reverse($lowerChars);
        
        // Восстанавливаем верхний регистр на ТЕХ ЖЕ ПОЗИЦИЯХ, где он был originally
        $result = '';
        foreach ($reversed as $i => $char) {
            // Если эта позиция в исходном слове была в верхнем регистре
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