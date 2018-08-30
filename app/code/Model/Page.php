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
    public $_currentPage = false;
    protected $dataSet = array();

    public function getUsers()
    {
        return $this->getCollection("users");
    }

    public function getCmsPage($id = 0, $forceLoad = false)
    {
        // TODO
//        if (!$this->_currentPage || $forceLoad) {
//            $this->getCollection("cms_pages", array("*"), array("page_id" => $id), array(), array(), true);
//            $this->_currentPage = $this->getFirstItem();
//            if (count($this->_currentPage)) {
//                $this->setDataSetItem($this->_currentPage);
//            }
//        }
//        return $this;

        //        $user = Slim::getModel("model/users");
        //        $user->setCurrentlyLoggedInUser(1);
        //        debug($user->dataSet);

        //        $this->setCmsNameValueString('abc');
        //        debug($this->setCms_nameValue_string('abc'));
        //        debug($this->getCms_nameValue_string());

        //        $this->setDataSetItem($this->_currentPage);
//        $this->setData("current_page", $this->_currentPage);
//        debug($this->dataSet);

        if (!$this->_currentPage || $forceLoad) {
            $this->getCollection("cms_pages", array("*"), array("page_id" => $id), array(), array(), true);
            $this->_currentPage = $this->getFirstItem();
        }
        return $this->_currentPage;
    }
}