<?php

use PHPUnit\Framework\TestCase;

class RestrictionSiteTest extends TestCase
{
    public function testGetComplement()
    {
        $site = new RestrictionSite("GGTACC", "Acc65I");
        $complement = $site->getComplement();
        $this->assertEquals("CCATGG", $complement->getNucleotides());
        $this->assertEquals("Acc65I Complement", $complement->getName());
    }
}
