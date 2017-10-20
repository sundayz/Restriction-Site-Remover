<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers InputParserTest
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
}
