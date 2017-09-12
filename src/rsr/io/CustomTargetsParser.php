<?php

class CustomTargetsParser
{
    /**
     * @var string
     */
    private $input;

    /**
     * @var int Internal counter for targets parsed.
     */
    private $counter;

    public function __construct(string $input)
    {
        $this->input = $input;
        $this->counter = 0;
    }

    /**
     * @return array An array of custom target sequences.
     */
    public function parseSites(): array
    {
        $sites = array();
        $tokens = explode("\n", $this->input);
        foreach ($tokens as $token) {
            $name = strtok($token, ',');
            $sequence = strtok('');
            if ($name === false && $sequence === false)
                throw new RuntimeException('Parsing the custom target sequence provided failed. Check your input for errors.');

            // Handle case where no name is given.
            if ($name !== false && $sequence === false)
            {
                $sequence = $name;
                $name = 'Custom Target ' . ++$this->counter;
            }

            $sequence = strtoupper($sequence);
            $this->sanitise($sequence);
            if (strlen($sequence) < 1)
                throw new RuntimeException('Parsing the custom target sequence provided failed. Check your input for errors.');

            array_push($sites, new RestrictionSite($sequence, $name));
        }
        return $sites;
    }

    /**
     * Removes any character that does not match a nucleotide.
     * @param $str string The string to clean.
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
