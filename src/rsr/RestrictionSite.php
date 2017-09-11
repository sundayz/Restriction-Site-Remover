<?php

class RestrictionSite
{
    /**
     * @var string The nucleotides that make up this restriction site.
     */
    private $nucleotides;

    /**
     * The human readable name for this restriction site.
     * @var string
     */
    private $name;

    /**
     * @var int Length of the restriction site.
     */
    private $len;

    public function __construct(string $nucleotides, string $name)
    {
        $this->nucleotides = $nucleotides;
        $this->name = $name;
        $this->len = strlen($nucleotides);
    }

    /**
     * Returns the nucleotides in the form of a string.
     * @return string
     */
    public function getNucleotides(): string
    {
        return $this->nucleotides;
    }

    /**
     * @return string The human readable name for this restriction site.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int The length of the restriction site.
     */
    public function getLength(): int
    {
        return $this->len;
    }

    /**
     * <p>Returns the complement of this restriction site.</p>
     * @return RestrictionSite The new restriction site.
     */
    public function getComplement()
    {
        $arr = str_split($this->nucleotides);
        for ($i = 0; $i < count($arr); ++$i)
        {
            switch ($arr[$i])
            {
            case 'A':
                $arr[$i] = 'T';
                break;
            case 'T':
                $arr[$i] = 'A';
                break;
            case 'C':
                $arr[$i] = 'G';
                break;
            case 'G':
                $arr[$i] = 'C';
                break;
            default:
                break;
            }
        }
        return new RestrictionSite(implode("", $arr), $this->name . ' Complement');
    }
}
