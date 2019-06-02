<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) {
    $rsDropdownData = RestrictionSites::getSites();
    return $this->view->render($response, 'templates/RSR.twig', [
        'pageTitle' => 'Home',
        'rsdata' => $rsDropdownData,
    ]);
});

$app->get('/about', function(Request $request, Response $response) {
    return $this->view->render($response, 'templates/about.twig', ['pageTitle' => 'About']);
});

$app->get('/help', function(Request $request, Response $response) {
    return $this->view->render($response, 'templates/help.twig', ['pageTitle' => 'Help']);
});

$app->post('/', function(Request $request, Response $response) {

    $postData = $request->getParsedBody();
    $ctx = [];

    /**
     * TODO: Replace. This used to be a method within the controller, but we don't use those anymore.
     * Creates an alert at the top of the screen, describing the issue.
     * @param string $msg The error message to display.
     * @return mixed
     */
    $showErrorMessage = function(string $msg) use ($postData, $response) {
        // Populate dropdown.
        $rsDropdownData = RestrictionSites::getSites();

        // Preserve user input.
        $userinput = [
            'seq' => $postData['dnasequence'],
            'customtargets' => $postData['customtargets'],
        ];

        return $this->view->render($response, 'templates/RSR.twig', [
            'userinput' => $userinput,
            'hasError' => true,
            'errorText' => $msg,
            'pageTitle' => 'RSR &mdash; An Error Has Occurred!',
            'rsdata' => $rsDropdownData,
        ]);
    };

    $t1 = microtime(true);
    if ($postData['dnasequence'] == null || $postData['dnasequence'] == '')
    {
        return $showErrorMessage('A DNA sequence must be provided.');
    }
    $parser = new InputParser($postData['dnasequence']);
    $parser->cleanDNA();
    if ($parser->getRaw() == '')
    {
        return $showErrorMessage('The DNA provided was a malformed format.');
    }
    $sites = $postData['sites'];
    if (!$sites || count($sites) < 1)
    {
        return $showErrorMessage('Please select at least one restriction site to remove.');
    }
    $dna = $parser->createDNASequence();

    // Create an array of Restriction Sites that we will be looking for.
    $restrictionSites = array();
    if ($postData['customtargets'])
    {
        $customParser = new CustomTargetsParser($postData['customtargets']);
        try
        {
            $customTargets = $customParser->parseSites();
            foreach ($customTargets as $target)
                array_push($restrictionSites, $target);
        }
        catch (RuntimeException $e)
        {
            return $showErrorMessage($e->getMessage());
        }
    }

    foreach ($sites as $nucleotides)
    {
        if ($nucleotides == "all")
        {
            $restrictionSites = RestrictionSites::getSites(); // Get all the sites. ignore the other input.
            break;
        }
        else if ($nucleotides == "rfc10")
        {
            RestrictionSites::pushRfc10($restrictionSites);
            continue;
        }
        else if ($nucleotides == "universal")
        {
            RestrictionSites::pushUniversal($restrictionSites);
            continue;
        }
        $val = RestrictionSites::getSite($nucleotides);
        if ($val == null)
            continue;

        array_push($restrictionSites, $val);
    }

    if (count($restrictionSites) < 1)
    {
        return $showErrorMessage('Please select at least one restriction site to remove.');
    }

    if (isset($postData['checkcomplements']))
    {
        $temp = array(); // Array of complements.
        foreach ($restrictionSites as $site)
            array_push($temp, $site->getComplement());

        foreach ($temp as $complementSite)
            array_push($restrictionSites, $complementSite);
    }

    try
    {
        $dna->findRestrictionSites($restrictionSites);
    }
    catch (ReadingFrameException $e)
    {
        return $showErrorMessage($e->getMessage());
    }
    $dnaresult = $dna->getResult();

    // Debug info
    $info = [
        'iterations' => $dna->info['iterations'],
        'failedmutations' => $dna->info['failedMutations'],
        'mutations' => count($dna->info['mutationIndices']),
        'checked' => count($restrictionSites),
        'found' => $dna->found,
        'timetaken' => (microtime(true) - $t1 . ' seconds')
    ];

    if ($dna->info['iterations'] > DNASequence::MAX_ITERATIONS)
    {
        $ctx['hasNotice'] = true;
        $ctx['noticeText'] = 'The maximum iteration count was hit. Not all sites may have been fully removed.';
    }

    $ctx['info'] = $info;
    $ctx['showDebug'] = isset($postData['showdebug']);
    $ctx['inputdna'] = $parser->getRaw();
    $ctx['dnaresult'] = $dnaresult;
    $ctx['pageTitle'] = 'RSR Results';
    $ctx['sites'] = $restrictionSites;

    return $this->view->render($response, 'templates/result.twig', $ctx);
});
