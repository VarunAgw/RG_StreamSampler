<?php

namespace VarunAgw\StreamSampler;

class StreamSampler {

    protected $stream;
    protected $size;

    /**
     * Returns truly random characters from a large stream
     * @param resource $stream File pointer to the stream
     * @param int $size Number of random characters to be returned
     */
    public function __construct($stream, int $size) {
        $this->stream = $stream;
        $this->size = $size;
    }

    /**
     * Process stream and return random characters
     * @return array array of random characters from stream
     * @throws \Exception
     */
    public function getRandomCharacters() {
        $stream = $this->stream;
        $size = $this->size;

        $randomCharacters = [];

        /*
         * Fill the array with first N character from stream
         */
        for ($i = 0; $i < $size; $i++) {
            $f = fgetc($stream);
            if (false === $f) {
                throw new \Exception('Input streamer smaller than required characters');
            } else {
                $randomCharacters[] = $f;
            }
        }

        /*
         * Adding more random characters based on random probability 
         * Larger the string, lesser probability becomes
         */
        while (false !== ($f = fgetc($stream))) {
            $i++;
            if (0 == random_int(0, $i)) {
                $key = random_int(0, $size - 1);
                $randomCharacters[$key] = $f;
            }
        }

        shuffle($randomCharacters);
        return $randomCharacters;
    }

}
