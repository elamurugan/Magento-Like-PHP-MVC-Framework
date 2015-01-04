<?php

class PageController extends Controller
{

    /**
     *
     */
    public function PageController()
    {

    }

    /**
     *
     */
    public function indexAction()
    {
        // $this->setSession('suc_message' ,"You logged in successfully"); // To set session
        // $this->getSession("suc_message");// To get session
        // $this->getParams(); // To get all params
        // $this->getParamsByType('post'); // To get all params by post type
        // $this->getParam("id");// To get id param
        // $this->model->getUsers();// To call Model file
        //parent::addJs("js/contacts.js");// To add Js from controller
        $this->setBodyClass("fixed");// To set Function specific Body class
        $this->setPageTitle("Home");
        $this->render("index",array("welcome_msg" => "Welcome Back"));
    }

    /**
     *
     */
    public function aboutAction()
    {
        $this->setPageTitle("About Us");
        $this->render("about");
    }

    public function contactAction()
    {
        $this->setPageTitle("Contact Us");
        $this->render("contact");
    }

    public function invalidAction()
    {
        parent::$rootLayout = 'invalid';
        $this->render("invalid");
    }

    public function clearcacheAction()
    {
        $this->clearCssJsCache();
        $this->redirect('page/index');
    }

    public function _sampleControllerFunction()
    {
        debug('Test to show controller level template call');
    }
}