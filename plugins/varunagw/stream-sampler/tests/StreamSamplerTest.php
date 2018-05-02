<?php

declare(strict_types=1);

use VarunAgw\StreamSampler\StreamSampler;
use PHPUnit\Framework\TestCase;

final class StreamSamplerTest extends TestCase {

    /**
     * Replace once from string
     * Complement for PHP str_replace()
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    protected function strReplaceOnce($search, $replace, $subject) {
        $pos = strpos($subject, $search);
        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }

    public function testInstance() {
        $this->assertInstanceOf(
                StreamSampler::class, new StreamSampler(STDIN, 2)
        );
    }

    /**
     * Test with very short stream
     * @depends testInstance
     */
    public function testVeryShortStream() {
        $this->expectException(\Exception::class);

        $fp = fopen('php://memory', 'r+');
        fputs($fp, 'hello');
        rewind($fp);

        $streamSampler = new StreamSampler($fp, 10);
        $streamSampler->getRandomCharacters();
    }

    /**
     * Test a proper sized stream
     * @depends testInstance
     */
    public function testStream() {
        $string = 'hello_world';

        $fp = fopen('php://memory', 'r+');
        fputs($fp, $string);
        rewind($fp);

        $streamSampler = new StreamSampler($fp, 5);
        $randomCharacters = $streamSampler->getRandomCharacters();

        $this->assertEquals(count($randomCharacters), 5);

        $string2 = $string;
        foreach ($randomCharacters as $randomCharacter) {
            $string2 = $this->strReplaceOnce($randomCharacter, '', $string2);
        }

        $this->assertEquals(strlen($string2), strlen($string) - 5, 'Stream return invalid response size');
    }

}
