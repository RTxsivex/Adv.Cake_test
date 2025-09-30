<?php

require_once 'WordReverser.php';

class WordReverserTest
{
    private $passed = 0;
    private $failed = 0;

    public function test(string $name, string $input, string $expected)
    {
        $result = \TestTask\WordReverser::reverse($input);
        
        if ($result === $expected) {
            echo "✅ PASS: $name\n";
            $this->passed++;
            return true;
        } else {
            echo "❌ FAIL: $name\n";
            echo "   Input:    '$input'\n";
            echo "   Expected: '$expected'\n";
            echo "   Got:      '$result'\n";
            $this->failed++;
            return false;
        }
    }

    public function runAll()
    {
        echo "🧪 Running WordReverser Tests\n";
        echo "==============================\n";

        // Тесты регистра
        $this->test('Latin simple case', 'Cat', 'Tac');
        $this->test('Cyrillic case', 'Мышь', 'Ьшым');
        $this->test('Mixed case', 'houSe', 'esuOh');
        $this->test('Cyrillic mixed case', 'домИК', 'кимОД');
        $this->test('Complex mixed case', 'elEpHant', 'tnAhPele');

        // Тесты пунктуации
        $this->test('Comma punctuation', 'cat,', 'tac,');
        $this->test('Colon punctuation', 'Зима:', 'Амиз:');
        $this->test('Quotes preservation', "is 'cold' now", "si 'dloc' won");
        $this->test('Various quotes', 'это «Так» "просто"', 'отэ «Кат» "отсорп"');

        // Тесты составных слов
        $this->test('Hyphenated word', 'third-part', 'driht-trap');
        $this->test('Apostrophe word', 'can`t', 'nac`t');

        // Краевые случаи
        $this->test('Empty string', '', '');
        $this->test('Only spaces', '   ', '   ');
        $this->test('Single letter', 'a', 'a');
        $this->test('Single uppercase letter', 'A', 'A');

        // Unicode и акценты
        $this->test('French accents', 'Éléphant', 'Tnahpélé');
        $this->test('Accented word', 'café', 'éfac');
        $this->test('Cyrillic with hyphen', 'Москва-сити', 'Авксом-итис');

        echo "==============================\n";
        echo "📊 Results: {$this->passed} passed, {$this->failed} failed\n";
        
        return $this->failed === 0;
    }
}


$test = new WordReverserTest();
$success = $test->runAll();
exit($success ? 0 : 1);