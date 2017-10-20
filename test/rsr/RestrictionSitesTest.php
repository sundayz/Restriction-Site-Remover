<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers RestrictionSites
 */
class RestrictionSitesTest extends TestCase
{
    /**
     * @covers RestrictionSites::getSite
     */
    public function testGetSite()
    {
        $site = RestrictionSites::getSite("GGTACC");
        $this->assertEquals("Acc65I", $site->getName());

        $siteNull = RestrictionSites::getSite("NotAValidSequence!");
        $this->assertNull($siteNull);
    }

    /**
     * @covers RestrictionSites::getSiteByName
     */
    public function testGetSiteByName()
    {
        $site = RestrictionSites::getSiteByName("XmaI");
        $this->assertEquals("CCCGGG", $site->getNucleotides());

        $siteNull = RestrictionSites::getSiteByName("NotARealSite!");
        $this->assertNull($siteNull);
    }

    /**
     * @covers RestrictionSites::getSites
     */
    public function testGetSites()
    {
        $sites = RestrictionSites::getSites();
        $this->assertTrue($this->isArrayOfType($sites, RestrictionSite::class));
    }

    /**
     * @param array $array The array to check.
     * @param $type string The type of objects the array should consist of.
     * @return bool
     */
    private function isArrayOfType(array $array, string $type)
    {
        foreach ($array as $site)
        {
            if ($site instanceof $type)
                continue;

            return false;
        }
        return true;
    }
}
