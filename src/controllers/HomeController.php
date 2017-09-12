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
        $userinput = array(
            'seq' => Flight::request()->data->dnasequence,
            'customtargets' => Flight::request()->data->customtargets
        );
        $this->putData('userinput', $userinput);
        if (Flight::request()->data->dnasequence == null || Flight::request()->data->dnasequence == '')
        {
            $this->showErrorMessage('A DNA sequence must be provided.');
            exit(1);
        }
        $parser = new InputParser(Flight::request()->data->dnasequence);
        $parser->sanitise();
        if ($parser->getRaw() == '')
        {
            $this->showErrorMessage('The DNA provided was a malformed format.');
            exit(1);
        }
        $sites = Flight::request()->data->sites;
        if (!$sites || count($sites) < 1)
        {
            $this->showErrorMessage('Please select at least one restriction site to remove.');
            exit(1);
        }
        $dna = $parser->createDNASequence();

        // Create an array of Restriction Sites that we will be looking for.
        $restrictionSites = array();
        if (Flight::request()->data->customtargets)
        {
            $customParser = new CustomTargetsParser(Flight::request()->data->customtargets);
            try
            {
                $customTargets = $customParser->parseSites();
                foreach ($customTargets as $target)
                    array_push($restrictionSites, $target);
            }
            catch (RuntimeException $e)
            {
                $this->showErrorMessage($e->getMessage());
                exit(1);
            }
        }

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

        if (count($restrictionSites) < 1)
        {
            $this->showErrorMessage('Please select at least one restriction site to remove.');
            exit(1);
        }

        try
        {
            $dna->findRestrictionSites($restrictionSites);
        }
        catch (ReadingFrameException $e)
        {
            $this->showErrorMessage($e->getMessage());
            exit(1);
        }
        $dnaresult = $dna->getResult();

        // Debug info
        $info = array(
            'iterations' => $dna->info['iterations'],
            'failedmutations' => $dna->info['failedMutations'],
            'mutations' => count($dna->info['mutationIndices']),
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

    /**
     * Creates an alert at the top of the screen, describing the issue.
     * @param string $msg The error message to display.
     */
    private function showErrorMessage(string $msg)
    {
        $rsDropdownData = RestrictionSites::getSites(); // Populate dropdown.
        $this->putData('hasError', true);
        $this->putData('errorText', $msg);
        $this->putData('pageTitle', 'RSR &mdash; An Error Has Occurred!');
        $this->putData('userinput', Flight::request()->query->dnasequence);
        $this->putData('pageTitle', 'Home');
        $this->putData('rsdata', $rsDropdownData);
        $this->render('templates/RSR.twig');
    }

    protected function before() { }
    protected function after() { }
}
