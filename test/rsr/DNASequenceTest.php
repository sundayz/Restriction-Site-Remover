<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers DNASequence
 */
class DNASequenceTest extends TestCase
{
    /**
     * @covers DNASequence::findRestrictionSites
     */
    public function testDoesNotMutate()
    {
        $dnaSequence = 'ATTAATAGGTATCCGGGATATATAT'; // Should never be mutated when checked against ASP718I and TspMI.
        $sites = array(
            RestrictionSites::getSiteByName('ASP718I'),
            RestrictionSites::getSiteByName('TspMI')
        );
        $dna = new DNASequence($dnaSequence);
        $dna->findRestrictionSites($sites);
        $result = $dna->getResult();
        $this->assertEquals('ATTAATAGGTATCCGGGATATATAT', $result->raw);
    }
}
