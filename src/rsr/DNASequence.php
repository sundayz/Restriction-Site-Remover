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
            'mutationIndices' => array()
        );
    }

    public function getResult(): DNAResult
    {
        $result = new DNAResult();
        $result->raw = $this->sequence;
        $result->formatted = $this->sequence;
        // Insert tags at the positions where we mutated sites, in reverse order.
        // Sort indices based on the 2nd number.
        $sorted = array();
        foreach ($this->info['mutationIndices'] as $key => $val)
            $sorted[$key] = $val[1];

        array_multisort($sorted, SORT_ASC, $this->info['mutationIndices']);
        for ($i = count($this->info['mutationIndices']) - 1; $i >= 0; --$i)
        {
            $result->formatted = substr_replace($result->formatted, '</span>', $this->info['mutationIndices'][$i][1], 0);
            $result->formatted = substr_replace($result->formatted, '<span class="bg-primary">', $this->info['mutationIndices'][$i][0], 0);
        }
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
                    $this->mutateRestrictionSite($pos, $site);
                elseif (($pos + 1) % 3 == 0)
                    $this->mutateRestrictionSite($pos + 1, $site);
                else
                    $this->mutateRestrictionSite($pos + 2, $site);
            }
            ++$this->info['iterations'];
            if ($lastFound == $this->found || $this->info['iterations'] > 100)
                $finished = true;
        }
    }

    /**
     * @param int $pos              The start position of the reading frame.
     * @param RestrictionSite $site The current site being mutated.
     */
    private function mutateRestrictionSite(int $pos, RestrictionSite $site)
    {
        $siteStart = $pos;
        while ($this->mutator->canAdvanceFrame($site, $pos, $siteStart, strlen($this->sequence)))
        {
            $codon = substr($this->sequence, $pos, 3);
            if ($this->mutator->silentMutation($codon))
            {
                $temp = 0;
                for ($i = $pos; $i < $pos + 3; ++$i)
                    $this->sequence[$i] = $codon[$temp++];

                array_push($this->info['mutationIndices'], array($pos, $pos + 3));
                return;
            }
            else
            {
                $pos += 3;
                $this->info['failedMutations'] += 1;
            }
        }
        throw new ReadingFrameException(
            sprintf('No mutation could be induced on %s (%s), at nucleotide %d, near ...%s...',
                $site->getName(),
                $site->getNucleotides(),
                $siteStart,
                substr($this->sequence, $siteStart - 2, 6 + 2)
            )
        );
    }
}