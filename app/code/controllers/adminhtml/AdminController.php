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
                $this->setSession('suc_message', "You logged in successfully");
                $this->redirect(_ADMIN_ROUTE_URL . '/admin/dashboard');
            } else {
                $this->setSession('err_message', 'Wrong user/password');
                $this->redirect('');
            }
            return;
        }
        $this->renderHtml(array());
    }

    public function logoutAction()
    {
        $this->resetApp();
        $this->redirect('');
    }
}