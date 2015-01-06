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
class Page extends Model
{
    public function Page()
    {

    }

    public function getUsers()
    {
        return $this->getCollection("users");
    }

    public function getCmsPage($id = 0)
    {
        $this->getCollection("cms_pages", array("*"), array("page_id" => $id));
        return $this->getFirstItem();
    }
}