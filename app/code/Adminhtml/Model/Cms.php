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
class Adminhtml_Model_Cms extends Model
{

    public function getCmsPages()
    {
        return $this->getCollection("cms_pages");
    }

    public function getCmsPage($id = 0)
    {
        $this->getCollection("cms_pages", array("*"), array("page_id" => $id));
        return $this->getFirstItem();
    }

    public function update_cms_data($params)
    {
        extract($params);
        $data = $params;
        $page_id = $data['page_id'];
        $title = $data['title'];

        $update_time = Utils::getCurrentTime();
        $data['update_time'] = $update_time;

        $this->update("cms_pages", $data, array("page_id" => $page_id));
        $msgs['type'] = 'suc_message';
        $msgs['msg'] = 'PAGE: "' . $title . '", Updated Successfully..!';

        return $msgs;
    }

    public function create_cms_page($params)
    {
        extract($params);
        $data = $params;
        $title = $data['title'];

        $creation_time = $update_time = Utils::getCurrentTime();
        $data['creation_time'] = $creation_time;
        $data['update_time'] = $update_time;

        $this->insert("cms_pages", $data);
        $msgs['type'] = 'suc_message';
        $msgs['msg'] = 'PAGE: "' . $title . '", Created Successfully..!';

        return $msgs;
    }
}