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
class Block_Template extends Block{

    public  function __construct()
    {

    }

    public  function getDataFromBlock()
    {
        $data = $this->model->getUsers();
        return $data;
    }
} 