<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers Mutator
 */
class MutatorTest extends TestCase
{
    /**
     * @var Mutator
     */
    private $mutator;

    protected function setUp()
    {
        $this->mutator = new Mutator();
    }

    /**
     * @covers Mutator::silentMutation
     */
    public function testSilentMutation()
    {
        $codon = "TTT"; // Phenylalanine only has 2 codons that code for it, so we know it should swap to TTC.
        $result = $this->mutator->silentMutation($codon);
        $this->assertEquals(true, $result);
        $this->assertEquals("TTC", $codon);
    }

    /**
     * @covers Mutator::isSameGroup
     */
    public function testIsSameGroup()
    {
        $codon1 = "TTA"; // Leucine
        $codon2 = "CTT"; // Leucine
        $codon3 = "GTT"; // Valine
        $this->assertEquals(true, $this->mutator->isSameGroup($codon1, $codon2));
        $this->assertEquals(false, $this->mutator->isSameGroup($codon2, $codon3));
    }

    /**
     * @covers Mutator::getGroup
     */
    public function testGetGroup()
    {
        $this->assertEquals("STOP", $this->mutator->getGroup("TAA"));
        $this->assertEquals("Lysine", $this->mutator->getGroup("AAA"));
    }

    /**
     * @covers Mutator::canMutate
     */
    public function testCanMutate()
    {
        $this->assertEquals(true, $this->mutator->canMutate("GCC"));
        $this->assertEquals(false, $this->mutator->canMutate("TGG"));
        $this->assertEquals(false, $this->mutator->canMutate("ATG"));
    }
}
