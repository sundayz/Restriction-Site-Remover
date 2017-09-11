<?php

class RestrictionSites
{
    /**
     * $sites[0] - The name of the restriction site.
     * $sites[1] - The sequence.
     * @var array
     */
    private static $sites = array(
        ["Acc65I", "GGTACC"],
        ["AgeI", "ACCGGT"],
        ["ApaI", "GGGCCC"],
        ["ApaLI", "GTGCAC"],
        ["AscI", "GGCGCGCC"],
        ["Asp718I", "GGTACC"],
        ["AvrII", "CCTAGG"],
        ["BamHI", "GGATCC"],
        ["BglII", "AGATCT"],
        ["BmgBI", "CACGTC"],
        ["BspDI", "ATCGAT"],
        ["BstBI", "TTCGAA"],
        ["ClaI", "ATCGAT"],
        ["EagI", "CGGCCG"],
        ["Ecl136II", "GAGCTC"],
        ["EcoRI", "GAATTC"],
        ["EcoRV", "GATATC"],
        ["HindIII", "AAGCTT"],
        ["HpaI", "GTTAAC"],
        ["KpnI", "GGTACC"],
        ["MluI", "ACGCGT"],
        ["NcoI", "CCATGG"],
        ["NdeI", "CATATG"],
        ["NheI", "GCTAGC"],
        ["NotI", "GCGGCCGC"],
        ["NsiI", "ATGCAT"],
        ["PacI", "TTAATTAA"],
        ["PaeR7I", "CTCGAG"],
        ["PspOMI", "GGGCCC"],
        ["PstI", "CTGCAG"],
        ["PvuI", "CGATCG"],
        ["PvuII", "CAGCTG"],
        ["SacI", "GAGCTC"],
        ["SacII", "CCGCGG"],
        ["SalI", "GTCGAC"],
        ["SmaI", "CCCGGG"],
        ["SnaBI", "TACGTA"],
        ["SpeI", "ACTAGT"],
        ["SphI", "GCATGC"],
        ["TliI", "CTCGAG"],
        ["TspMI", "CCCGGG"],
        ["XbaI", "TCTAGA"],
        ["XhoI", "CTCGAG"],
        ["XmaI", "CCCGGG"]
    );

    /**
     * @param string $sequence
     * @return null|RestrictionSite
     */
    public static function getSite(string $sequence)
    {
        $sequence = strtoupper($sequence);
        for ($i = 0; $i < count(self::$sites); ++$i)
        {
            if (self::$sites[$i][1] == $sequence)
                return new RestrictionSite($sequence, self::$sites[$i][0]);
        }
        return null;
    }

    /**
     * @param string $name The name of the restriction site.
     * @return null|RestrictionSite
     */
    public static function getSiteByName(string $name)
    {
        $name = strtolower($name);
        for ($i = 0; $i < count(self::$sites); ++$i)
        {
            if (strtolower(self::$sites[$i][0]) == $name)
                return new RestrictionSite(self::$sites[$i][1], self::$sites[$i][0]);
        }
        return null;
    }

    /**
     * Returns an array of RestrictionSite objects.
     * @return array
     */
    public static function getSites(): array
    {
        $temp = array();
        for ($i = 0; $i < count(self::$sites); ++$i)
        {
            $name = self::$sites[$i][0];
            $sequence = self::$sites[$i][1];
            array_push($temp, new RestrictionSite($sequence, $name));
        }
        return $temp;
    }
}
