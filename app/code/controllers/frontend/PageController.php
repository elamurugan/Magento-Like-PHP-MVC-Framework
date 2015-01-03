<?php

class PageController extends Controller
{

    public function PageController()
    {
        parent::$layout = '1column';
    }

    public function indexAction($_app_params)
    {
        global $app;
        // $this->setSession('suc_message' ,"You logged in successfully"); // To set session
        // $this->getSession("suc_message");// To get session
        // $this->getParams(); // To retrive all params
        // $this->getParamsByType('post'); // To retrive all params by post type
        // $this->getParam("id");// To retrive id param
        // $this->model->getUsers();// To call Model file
        $this->setBodyClass("fixed");// To set Function specific Body class
        $this->setPageTitle("Home");
        $this->render("index", array());
    }

    public function aboutAction($_app_params)
    {
        global $app;
        parent::$layout = '3column';
        $this->setPageTitle("About Us");
        $this->render("about", array());
    }

    public function contactAction($_app_params)
    {
        global $app;
        parent::$layout = '2column-left';
        parent::addJs("js/contacts.js");
        $this->setPageTitle("Contact Us");
        $this->render("contact", array());
    }

    public function invalidAction($_app_params)
    {
        global $app;
        parent::$layout = 'invalid';
        $this->render("invalid", array());
    }

    public function clearcacheAction($_app_params)
    {
        $this->clearCssJsCache();
        $this->redirect('page/index');
    }

    public function _sampleControllerFunction()
    {
        debug('test to show controller level template call');
    }
}