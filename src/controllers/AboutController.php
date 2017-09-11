<?php

class AboutController extends BaseController
{
    public function index()
    {
        $this->putData('pageTitle', 'About');
        $this->render('templates/about.twig');
    }

    protected function before() { }
    protected function after() { }
}
