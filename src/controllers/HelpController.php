<?php

class HelpController extends BaseController
{
    public function index()
    {
        $this->putData('pageTitle', 'Help');
        $this->render('templates/help.twig');
    }

    protected function before() { }
    protected function after() { }
}
