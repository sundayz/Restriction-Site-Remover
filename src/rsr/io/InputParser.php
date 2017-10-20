<?php

class InputParser
{
    private $dna;

    /**
     * @param string $dna The DNA sequence.
     */
    public function __construct(string $dna)
    {
        $this->dna = strtoupper($dna);
    }

    public function createDNASequence(): DNASequence
    {
        return new DNASequence($this->dna);
    }

    public function getRaw(): string
    {
        return $this->dna;
    }

    /**
     * Removes non-nucleotide characters from DNA.
     */
    public function cleanDNA()
    {
        self::sanitise($this->dna);
    }

    /**
     * Removes any character that does not match a nucleotide.
     * @param $str string The string to clean.
     */
    public static function sanitise(string &$str)
    {
        $temp = $str;
        $str = '';
        for ($i = 0; $i < strlen($temp); ++$i) {
            switch ($temp[$i]) {
                case 'A':
                case 'T':
                case 'G':
                case 'C':
                    $str .= $temp[$i];
                    break;
                default:
                    break;
            }
        }
    }
}
