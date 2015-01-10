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
class Controller_Users extends Controller
{

    public function UsersController()
    {
    }

    public function indexAction()
    {
        $this->setPageTitle("Profile");
        if ($this->model->isUserLoggedIn()) {
            $this->redirect('users/profile');
        } else {
            $this->renderHtml(array());
        }
    }

    public function loginAction()
    {
        if ($this->model->isUserLoggedIn()) {
            $this->redirect('users/profile');
            return;
        } elseif (isset($_POST)) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->login($postParams);
            if ($response && count($response)) {
                $this->setSession("user", $response);
                $this->setSession('suc_message',
                                  "Welcome Back, " . ucfirst($response['username']) . ".. You logged in successfully..!"
                );
                $this->redirect('users/profile');
            } else {
                $this->setSession('err_message', 'Wrong user/password');
                $this->redirect('users/login');
            }
            return;
        }
        $this->renderHtml(array());
    }

    public function createAction()
    {
        if (isset($_POST)) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->create($postParams);
            $this->setSession($response['type'], $response['msg']);
            if ($response['type'] == 'err_message') {
                $this->redirect("users/create");
            } elseif ($response['type'] == 'suc_message') {
                $this->redirect("users/login");
            } else {
                $this->redirect("users/create");
            }
            return;
        }
        $this->renderHtml();
    }

    public function forget_passwordAction()
    {
        $this->renderHtml(array());
    }

    public function profileAction()
    {
        if ($this->model->isUserLoggedIn()) {
            $this->renderHtml(array());
        } else {
            $this->redirect('users/login');
        }
    }

    public function profileviewAction()
    {
        $current_user = Slim::registry('current_user');
        $this->renderHtml(array("current_user" => $current_user));
    }

    public function logoutAction()
    {
        $this->resetApp();
        $this->redirect("users/login");
    }
}