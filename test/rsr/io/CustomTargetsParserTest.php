<?php

use PHPUnit\Framework\TestCase;

class CustomTargetsParserTest extends TestCase
{
    public function testParser()
    {
        $text = 'Sequence, AGTCT';
        $pasrer = new CustomTargetsParser($text);
        $arr = $pasrer->parseSites();
        $this->assertEquals('Sequence', $arr[0]->getName());
        $this->assertEquals('AGTCT', $arr[0]->getNucleotides());
    }
}
