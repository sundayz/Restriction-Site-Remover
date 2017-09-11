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
     * Removes any character that does not match a nucleotide.
     */
    public function sanitise()
    {
        $temp = "";
        for ($i = 0; $i < strlen($this->dna); ++$i)
        {
            switch ($this->dna[$i])
            {
            case 'A':
            case 'T':
            case 'G':
            case 'C':
                $temp .= $this->dna[$i];
                break;
            default:
                break;
            }
        }
        $this->dna = $temp;
    }
}
