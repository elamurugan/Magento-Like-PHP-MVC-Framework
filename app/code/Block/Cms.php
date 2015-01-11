<?php
/**
 * Template *
 * @category ${VENDOR}
 * @package ${VENDOR}_<module>
 * @copyright Copyright (c) 2015 Alpine Consulting, Inc (www.alpineinc.com)
 * @author Nicholas Castelli (ncastelli@alpineinc.com)
 * Date: 08-01-2015
 * Time: 04:38 PM
 */

/**
 * <Class short Desc>
 *
 * @category ${VENDOR}
 * @package ${VENDOR}_<module>
 */
class Block_Cms extends Block{

    public  function __construct()
    {
        // to set template file from Block
//        $tempFile = '';
//        $this->_templateFile = $tempFile;
    }

    public  function getCmsContent()
    {
        $cmsPage = $this->model->_currentPage;
        $content = $cmsPage->content;
        $helper = new Helper();
        $content = $helper->processCmsContent($content);
        return $content;
    }
} 