<?php

use PHPUnit\Framework\TestCase;

class MutatorTest extends TestCase
{
    public function testSilentMutation()
    {
        $mutator = new Mutator();
        $codon = "TTT"; // Phenylalanine only has 2 codons that code for it, so we know it should swap to TTC.
        $result = $mutator->silentMutation($codon);
        $this->assertEquals(true, $result);
        $this->assertEquals("TTC", $codon);
    }

    public function testIsSameGroup()
    {
        $mutator = new Mutator();
        $codon1 = "TTA"; // Leucine
        $codon2 = "CTT"; // Leucine
        $codon3 = "GTT"; // Valine
        $this->assertEquals(true, $mutator->isSameGroup($codon1, $codon2));
        $this->assertEquals(false, $mutator->isSameGroup($codon2, $codon3));
    }

    public function testGetGroup()
    {
        $mutator = new Mutator();
        $this->assertEquals("STOP", $mutator->getGroup("TAA"));
        $this->assertEquals("Lysine", $mutator->getGroup("AAA"));
    }

    public function testCanMutate()
    {
        $mutator = new Mutator();
        $this->assertEquals(true, $mutator->canMutate("GCC"));
        $this->assertEquals(false, $mutator->canMutate("TGG"));
        $this->assertEquals(false, $mutator->canMutate("ATG"));
    }
}
