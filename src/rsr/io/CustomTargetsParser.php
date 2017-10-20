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
            Inputparser::sanitise($sequence);
            if (strlen($sequence) < 3 || strlen($sequence) > 16)
                throw new RuntimeException('Parsing the custom target sequence provided failed. Check your input for errors. Custom targets must be longer than three nucleotides.');

            array_push($sites, new RestrictionSite($sequence, $name));
        }
        return $sites;
    }
}
