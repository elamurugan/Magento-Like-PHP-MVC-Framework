<?php

class UsersController extends Controller
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
                $this->setSession('suc_message', "You logged in successfully");
                $this->redirect('users/profile');
            } else {
                $this->setSession('err_message', 'Wrong user/password');
                $this->redirect('');
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
            $this->redirect("users/profile");
            return;
        }
        $this->renderHtml();
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
        $this->renderHtml(array());
    }

    public function logoutAction()
    {
        $this->resetApp();
        $this->redirect("");
    }
}