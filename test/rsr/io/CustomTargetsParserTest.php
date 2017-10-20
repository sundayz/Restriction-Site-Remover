<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers CustomTargetsParser
 */
class CustomTargetsParserTest extends TestCase
{
    /**
     * @covers CustomTargetsParser::parseSites
     */
    public function testParser()
    {
        $text = 'Sequence, AGTCT';
        $pasrer = new CustomTargetsParser($text);
        $arr = $pasrer->parseSites();
        $this->assertEquals('Sequence', $arr[0]->getName());
        $this->assertEquals('AGTCT', $arr[0]->getNucleotides());
    }
}
