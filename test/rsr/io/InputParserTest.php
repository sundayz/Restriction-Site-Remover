<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers InputParser
 */
class InputParserTest extends TestCase
{
    /**
     * @covers InputParser::createDNASequence
     */
    public function testCreateDNASequence()
    {
        $dnaText = "GGGCCCAAATTT";
        $parser = new InputParser($dnaText);
        $sequence = $parser->createDNASequence();
        $this->assertEquals($dnaText, $sequence->sequence);
    }

    /**
     * @covers InputParser::cleanDNA
     */
    public function testCleanDNA()
    {
        $dna = "AxTGxzCGCxyz";
        $parser = new InputParser($dna);
        $parser->cleanDNA();
        $this->assertEquals("ATGCGC", $parser->createDNASequence()->sequence);
    }

    /**
     * @covers InputParser::sanitise
     */
    public function testSanitise()
    {
        $dna = "zzzAGCGGCpGCGC;1";
        InputParser::sanitise($dna);
        $this->assertEquals("AGCGGCGCGC", $dna);
    }

    /**
     * @covers InputParser::getRaw
     */
    public function testGetRaw()
    {
        $dna = "agcagcGCA";
        $parser = new InputParser($dna);
        $this->assertEquals("AGCAGCGCA", $parser->getRaw());
    }
}
