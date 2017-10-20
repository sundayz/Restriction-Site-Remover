<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers RestrictionSite
 */
class RestrictionSiteTest extends TestCase
{

    /**
     * @covers RestrictionSite::getComplement
     */
    public function testGetComplement()
    {
        $site = new RestrictionSite("GGTACC", "Acc65I");
        $complement = $site->getComplement();
        $this->assertEquals("GGTACC", $complement->getNucleotides());
        $this->assertEquals("Acc65I Complement", $complement->getName());
    }
}
