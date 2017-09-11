<?php

/**
 * Can perform silent mutations which preserve the specific
 * amino acid coded for, but change the DNA sequence.
 */
class Mutator
{
    private $groups;

    public function __construct()
    {
        $this->groups = array(
            "Phenylalanine" =>  array('TTT', 'TTC'),
            "Leucine" =>        array('TTA', 'TTG', 'CTT', 'CTC', 'CTA', 'CTG'),
            "Isoleucine" =>     array('ATT', 'ATC', 'ATA'),
            "Methionine" =>     array('ATG'),
            "Valine" =>         array('GTT', 'GTC', 'GTA', 'GTG'),
            "Serine" =>         array('TCT', 'TCC', 'TCA', 'TCG', 'AGT', 'AGC'),
            "Proline" =>        array('CCT', 'CCC', 'CCA', 'CCG'),
            "Threonine" =>      array('ACT', 'ACC', 'ACA', 'ACG'),
            "Alanine" =>        array('GCT', 'GCC', 'GCA', 'GCG'),
            "Tyrosine" =>       array('TAT', 'TAC'),
            "STOP" =>           array('TAA', 'TAG', 'TGA'),
            "Histidine" =>      array('CAT', 'CAC'),
            "Glutamine" =>      array('CAA', 'CAG'),
            "Asparagine" =>     array('AAT', 'AAC'),
            "Lysine" =>         array('AAA', 'AAG'),
            "Aspartate" =>      array('GAT', 'GAC'),
            "Glutamate" =>      array('GAA', 'GAG'),
            "Cysteine" =>       array('TGT', 'TGC'),
            "Arginine" =>       array('CGT', 'CGC', 'CGA', 'CGG', 'AGA', 'AGG'),
            "Glycine" =>        array('GGT', 'GGC', 'GGA', 'GGG'),
            "Tryptophan" =>     array('TGG')
        );
    }

    /**
     * ATG and TGG cannot be mutated because they have no other codons that code for the same amino acid.
     * @param string $codon The codon to check.
     * @return bool
     */
    public function canMutate(string $codon): bool
    {
        if ($codon == 'TGG' || $codon == 'ATG')
            return false;

        return true;
    }

    /**
     * Returns the name of the amino acid this codon is coding for.
     * @param string $codon The codon to check.
     * @return string       The name of the amino acid.
     */
    public function getGroup(string $codon): string
    {
        foreach ($this->groups as $aminoAcid => $codons)
        {
            $result = array_search($codon, $codons);
            if ($result === false)
                continue;

            return $aminoAcid;
        }
        return null;
    }

    /**
     * @param string $codon1
     * @param string $codon2
     * @return bool
     */
    public function isSameGroup(string $codon1, string $codon2)
    {
        return $this->getGroup($codon1) == $this->getGroup($codon2);
    }

    /**
     * Searches for possible mutations that do not interfere with the
     * amino acid this codon is coding for, and incudes a silent mutation.
     * @param string $codon The codon to mutate.
     * @return bool Returns true if $codon has been mutated, otherwise false.
     */
    public function silentMutation(string &$codon): bool
    {
        if (strlen($codon) != 3)
            return false;

        if (!$this->canMutate($codon)) // This should have already been checked, but just in case.
            return false;

        $index = $this->getGroup($codon);
        if ($index == null)
            return false;

        $temp = $this->groups[$index];
        if (($key = array_search($codon, $temp)) !== false)
            unset($temp[$key]);
        else
            return false;

        $temp = array_values($temp); // Re-index array.
        if (count($temp) == 0)       // No mutations possible.
            throw new RuntimeException("Tried to mutate " . $index); // TODO

        $codon = $temp[array_rand($temp)];
        return true;
    }
}
