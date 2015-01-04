<?php

class AdminController extends Controller
{

    public function AdminController()
    {
    }

    public function dashboardAction()
    {
        $this->setPageTitle("Dashboard");
        if (!$this->model->isUserLoggedIn()) {
            $this->redirect(_ADMIN_ROUTE_URL . '/admin/login');
        }
        $this->render("dashboard", array());
    }

    public function loginAction()
    {
        if ($this->model->isUserLoggedIn()) {
            $this->redirect(_ADMIN_ROUTE_URL . '/admin/dashboard');
            return;
        } elseif (isset($_POST)) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->login($postParams);
            if ($response && count($response)) {
                $this->setSession("user", $response);
                $this->setSession('suc_message', "You logged in successfully");
                $this->redirect(_ADMIN_ROUTE_URL . '/admin/dashboard');
            } else {
                $this->setSession('err_message', 'Wrong user/password');
                $this->redirect('');
            }
            return;
        }
        $this->render("login", array());
    }

    public function logoutAction()
    {
        $this->resetApp();
        $this->redirect(_ADMIN_ROUTE_URL . "/");
    }
}