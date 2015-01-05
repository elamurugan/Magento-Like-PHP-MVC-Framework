<?php
/**
 * SLIM_MVC_Framework
 *
 * @category  controllers
 * @package   SLIM_MVC_Framework
 * @copyright Copyright (c) 2014 (http://www.elamurugan.com/)
 * @author    Ela <nelamurugan@gmail.com>
 */

/**
 * Class SLIM_MVC_Framework
 *
 * @category    controllers
 * @package     SLIM_MVC_Framework
 */
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
    public function viewAction()
    {
        $page = $this->model->getCmsPage($this->getParam("id"));

        if (count($page)) {
            $this->setPageTitle("About Us");
            $this->updateTemplate("root", $page['root_template']);
            $this->renderHtml(array("cms_page" => $page));
        } else {
            $this->redirect('page/error404');
        }
    }

    public function contactAction()
    {
        //        $post = $this->getParamsByType("post");
        //        $content = $this->renderTemplate("emails/contact.phtml", array('data' => $post));
        //        $response = $this->sendEmail($from, $fromname, $to, $toname, $subject, $content);

        $this->setPageTitle("Contact Us");
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