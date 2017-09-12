<?php

class CustomTargetsParser
{
    /**
     * @var string
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    /**
     * @return array An array of custom target sequences.
     */
    public function parseSites(): array
    {
        $sites = array();
        $tokens = explode("\n", $this->input);
        foreach ($tokens as $token)
        {
            $name = strtok($token, ',');
            $sequence = strtok('');
            if ($name === false || $sequence === false)
                throw new RuntimeException('Parsing the custom target sequence provided failed.');

            $sequence = strtoupper($sequence);
            $this->sanitise($sequence);
            array_push($sites, new RestrictionSite($sequence, $name));
        }
        return $sites;
    }

    /**
     * Removes any character that does not match a nucleotide.
     */
    public function sanitise(string &$str)
    {
        $temp = $str;
        $str = '';
        for ($i = 0; $i < strlen($temp); ++$i)
        {
            switch ($temp[$i])
            {
                case 'A':
                case 'T':
                case 'G':
                case 'C':
                    $str .= $temp[$i];
                    break;
                default:
                    break;
            }
        }
    }
}
