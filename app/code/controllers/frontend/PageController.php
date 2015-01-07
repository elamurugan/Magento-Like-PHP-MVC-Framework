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
            if ($page['root_template'] != '') {
                $this->updateTemplate("root", $page['root_template']);
            }
            $this->renderHtml(array("cms_page" => $page));
        } else {
            $this->redirect('page/error404');
        }
    }

    public function contactAction()
    {
        if(isset($_POST)){
            $params = $this->getParamsByType("post");
            $content = $this->renderTemplate("emails/contact.phtml", array('data' => $params));
            $helper = new Helper();
            $configdata = $this->model->getConfigData();
            $from      = 'from@example.com';
            $fromname  = 'Framework';
            $to        = $configdata['contact_email'];
            $toname    = $configdata['contact_name'];
            $subject   = 'New Message from '.$configdata['site_title'];
            $response  = $helper->sendEmail($from, $fromname, $to, $toname, $subject, $content);

            $msgs['type'] = 'suc_message';
            $msgs['msg'] = 'We Received your Message..! We will get back to you Soon..!';
            $this->setSession($msgs['type'], $msgs['msg']);
            $this->redirect('page/contact');
        }

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
        return array("some_key" => 'Test to show controller level template call like to use block logic');
    }
}