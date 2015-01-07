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
class CmsController extends Controller
{

    public function CmsController()
    {
        $this->setPageTitle("Cms");
    }

    public function indexAction()
    {
        $this->setPageTitle("CmsIndex");
        $all_cms_pages = $this->model->getCmsPages();
        $this->renderHtml(array("all_cms_pages" => $all_cms_pages));
    }

    public function editpageAction()
    {
        $this->setPageTitle("Edit CMS Page");
        if (!$this->model->isUserLoggedIn()) {
            $this->redirect('admin/login');
            return;
        } elseif (isset($_POST)) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->update_cms_data($postParams);
            $this->setSession($response['type'], $response['msg']);
            $this->redirect("cms/index");
            return;
        }
        $page_id = $this->getParam('id');
        $cms_page_data = $this->model->getCmsPage($page_id);
        $this->renderHtml(array("cms_page_data" => $cms_page_data));

    }

    public function createpageAction()
    {
        $this->setPageTitle("Create CMS Page");
        if (!$this->model->isUserLoggedIn()) {
            $this->redirect('admin/login');
            return;
        } elseif (isset($_POST)) {
            $postParams = $this->getParamsByType('post');
            $response = $this->model->create_cms_page($postParams);
            $this->setSession($response['type'], $response['msg']);
            $this->redirect("cms/index");
            return;
        }
        $this->renderHtml(array());
    }
}