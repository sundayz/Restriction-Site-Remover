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
     * @return RestrictionSite[]
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

    /* Presets */

    /**
     * @param array $array The array in which to insert the RestrictionSite objects for iGEM RFC 10.
     */
    public static function pushRfc10(array &$array)
    {
        array_push($array, new RestrictionSite("GAATTC", "EcoRI"));
        array_push($array, new RestrictionSite("TCTAGA", "XbaI"));
        array_push($array, new RestrictionSite("ACTAGT", "SpeI"));
        array_push($array, new RestrictionSite("CTGCAG", "PstI"));
        array_push($array, new RestrictionSite("GCGGCCGC", "NotI"));
    }

    /**
     * @param array $array The array in which to insert the RestrictionSite objects for iGEM Universal Compatibility.
     */
    public static function pushUniversal(array &$array)
    {
        array_push($array, new RestrictionSite("GAATTC", "EcoRI"));
        array_push($array, new RestrictionSite("TCTAGA", "XbaI"));
        array_push($array, new RestrictionSite("ACTAGT", "SpeI"));
        array_push($array, new RestrictionSite("CTGCAG", "PstI"));
        array_push($array, new RestrictionSite("GCGGCCGC", "NotI"));
        array_push($array, new RestrictionSite("GCTAGC", "NheI"));
        array_push($array, new RestrictionSite("CAGCTG", "PvuII"));
        array_push($array, new RestrictionSite("CTCGAG", "XhoI"));
        array_push($array, new RestrictionSite("CCTAGG", "AvrII"));
        array_push($array, new RestrictionSite("GCTCTTC", "SapI"));
        array_push($array, new RestrictionSite("GAAGAGC", "SapI2"));
        array_push($array, new RestrictionSite("AGATCT", "BglII"));
        array_push($array, new RestrictionSite("GGATCC", "BamHI"));
        array_push($array, new RestrictionSite("GCCGGC", "NgoMIV"));
        array_push($array, new RestrictionSite("ACCGGT", "AgeI"));
        array_push($array, new RestrictionSite("GAAGAC", "BpiI"));
        array_push($array, new RestrictionSite("GAAGAC", "BbsI"));
        array_push($array, new RestrictionSite("GGTCTC", "BsaI"));
    }
}
