<?php

class DNASequence
{
    /**
     * @var string The sequence as a string.
     */
    public $sequence;

    /**
     * @var int Restriction sites found
     */
    public $found;

    /**
     * @var Mutator
     */
    private $mutator;

    public $info;

    public function __construct(string $sequence)
    {
        $this->sequence = $sequence;
        $this->found = 0;
        $this->mutator = new Mutator();
        $this->mutationIndices = array();
        $this->info = array(
            'failedMutations' => 0,
            'iterations' => 0,
            'mutationIndieces' => array()
        );
    }

    public function getResult(): DNAResult
    {
        $result = new DNAResult();
        $result->raw = str_replace(array('^', '#'), array('', ''), $this->sequence);
        $result->formatted = str_replace(array('^', '#'), array('<span class="bg-primary">', '</span>'), chunk_split($this->sequence, 100)); ;
        return $result;
    }

    /**
     * Iterates <i>$restrictionSites</i> and silently mutates where possible.
     * @param array $restrictionSites An array of sites to check for.
     */
    public function findRestrictionSites(array $restrictionSites)
    {
        $finished = false;
        while (!$finished)
        {
            $lastFound = $this->found;
            foreach ($restrictionSites as $site)
            {
                $pos = strpos($this->sequence, $site->getNucleotides());
                if ($pos === false)
                    continue;

                ++$this->found;
                if ($pos % 3 == 0)
                    $this->mutateRestrictionSite($pos);
                elseif (($pos + 1) % 3 == 0)
                    $this->mutateRestrictionSite($pos + 1);
                else
                    $this->mutateRestrictionSite($pos + 2);
            }
            ++$this->info['iterations'];
            if ($lastFound == $this->found || $this->info['iterations'] > 100)
                $finished = true;
        }
    }

    /**
     * @param int $pos The start position of the reading frame.
     */
    private function mutateRestrictionSite(int $pos)
    {
        array_push($this->info['mutationIndieces'], $pos);
        $codon = substr($this->sequence, $pos, 3);
        if (!$this->mutator->silentMutation($codon))
        {
            $this->info['failedMutations'] += 1;
            return;
        }

        // $this->sequence = substr_replace($this->sequence, $codon, $pos);
        $temp = 0;
        for ($i = $pos; $i < $pos + 3; ++$i)
            $this->sequence[$i] = $codon[$temp++];

        $this->sequence = str_replace($codon, "^" . $codon . "#", $this->sequence); // <strong> tags
    }
}
