<?php

class AboutController extends BaseController implements IndexedController
{
    public function index()
    {
        $this->putData('pageTitle', 'About');
        $this->render('templates/about.twig');
    }

    protected function before() { }
    protected function after() { }
}
