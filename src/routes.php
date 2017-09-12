<?php

/* Home */
Flight::route('GET /', function()
{
    $home = new HomeController();
    $home->index();
});

Flight::route('POST /', function()
{
    $home = new HomeController();
    $home->parseDNA();
});

/* About */
Flight::route('GET /about', function()
{
    $about = new AboutController();
    $about->index();
});

/* Help */
Flight::route('GET /help', function()
{
    $help = new HelpController();
    $help->index();
});
