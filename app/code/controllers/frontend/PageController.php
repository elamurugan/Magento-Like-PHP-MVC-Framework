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
        $this->renderHtml(array("welcome_msg" => "Welcome Back"));
    }

    /**
     *
     */
    public function aboutAction()
    {
        $this->setPageTitle("About Us");
        $this->renderHtml();
    }

    public function contactAction()
    {
        $this->setPageTitle("Contact Us");
        $this->renderHtml();
    }

    public function invalidAction()
    {
        $this->setPageTitle("Invalid Page");
        $this->renderHtml();
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