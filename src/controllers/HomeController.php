<?php

class HomeController extends BaseController
{
    public function index()
    {
        $rsDropdownData = RestrictionSites::getSites();
        $this->putData('pageTitle', 'Home');
        $this->putData('rsdata', $rsDropdownData);
        $this->render('templates/RSR.twig');
    }

    public function parseDNA()
    {
        $t1 = microtime(true);
        $parser = new InputParser(Flight::request()->data->dnasequence);
        $parser->sanitise();
        $sites = Flight::request()->data->sites;
        $dna = $parser->createDNASequence();

        // Create an array of Restriction Sites that we will be looking for.
        $restrictionSites = array();
        foreach ($sites as $nucleotides)
        {
            if ($nucleotides == "all")
            {
                $restrictionSites = RestrictionSites::getSites(); // Get all the sites. ignore the other input.
                break;
            }

            $val = RestrictionSites::getSite($nucleotides);
            if ($val == null)
                continue;

            array_push($restrictionSites, $val);
        }
        $dna->findRestrictionSites($restrictionSites);
        $dnaresult = $dna->getResult();

        // Debug info
        $info = array(
            'iterations' => $dna->info['iterations'],
            'failedmutations' => $dna->info['failedMutations'],
            'mutations' => count($dna->info['mutationIndieces']),
            'checked' => count($restrictionSites),
            'found' => $dna->found,
            'timetaken' => (microtime(true) - $t1 . ' seconds')
        );

        $this->putData('info', $info);
        $this->putData('showDebug', true);
        $this->putData('inputdna', $parser->getRaw());
        $this->putData('dnaresult', $dnaresult);
        $this->putData('pageTitle', 'RSR Results');
        $this->putData('sites', $restrictionSites);
        $this->render('templates/result.twig');
    }

    protected function before() { }
    protected function after() { }
}
