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
class AdminController extends Controller
{

    public function AdminController()
    {
    }

    public function dashboardAction()
    {
        $this->setPageTitle("Dashboard");
        if (!$this->model->isUserLoggedIn()) {
            $this->redirect('admin/login');
        }
        $this->renderHtml(array());
    }

    public function loginAction()
    {
        if ($this->model->isUserLoggedIn()) {
            $this->redirect('admin/dashboard');
            return;
        } elseif (isset($_POST)) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->login($postParams);
            if ($response && count($response)) {
                $this->setSession("user", $response);
                $this->setSession('suc_message', "Admin logged in successfully..!");
                $this->redirect('admin/dashboard');
            } else {
                $this->setSession('err_message', 'Wrong user/password');
                $this->redirect('admin/login');
            }
            return;
        }
        $this->renderHtml(array());
    }
    
    public function forget_passwordAction()
    {
        $this->renderHtml(array());
    }

    public function accountAction()
    {
        if ($_POST) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->update_user_data($postParams);
            $this->setSession($response['type'], $response['msg']);
            $this->redirect("admin/account");
            return;
        }
        $this->renderHtml(array());
    }

    public function usersAction()
    {
        $this->renderHtml(array());
    }

    public function edit_usersAction()
    {
        if ($_POST) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->update_user_data($postParams);
            $this->setSession($response['type'], $response['msg']);
            $this->redirect("admin/users");
            return;
        }
        $id = $this->getParam('id');
        $current_user = $this->model->getCollection('users', array(), array('id' => $id));
        $this->renderHtml(array("current_user" => $current_user[0]));
    }

    public function systemAction()
    {
        $this->renderHtml(array());
    }

    public function logoutAction()
    {
        $this->resetApp();
        $this->redirect('admin/login');
    }
}