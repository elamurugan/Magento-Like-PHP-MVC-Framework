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
class Model_Page extends Model
{

    public function getUsers()
    {
        return $this->getCollection("users");
    }

    public function getCmsPage($id = 0)
    {
//        $cmsPage = array();
//        $cms = Slim::getModel("model/cms");
//        $cmsPage = $cms->getCmsPage($id);

        $this->getCollection("cms_pages", array("*"), array("page_id" => $id),array(),array(),true);
        $cmsPage =  $this->getFirstItem();
        return $cmsPage;
    }
}