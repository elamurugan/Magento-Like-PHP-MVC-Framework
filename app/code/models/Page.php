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
        $qry = "SELECT * FROM `{$this->getTable("users")}`";
        return $result = $this->fetch($qry);
    }

    public function getCmsPage($id = 0)
    {
        $qry = "SELECT * FROM `{$this->getTable("cms_pages")}` where page_id = '$id'";
        return $result = $this->fetchFirstRow($qry);
    }
}