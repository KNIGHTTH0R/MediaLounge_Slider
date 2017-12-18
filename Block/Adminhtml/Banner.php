<?php

namespace MediaLounge\Slider\Block\Adminhtml;

class Banner extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'MediaLounge_Slider';
        $this->_headerText = __('Banners');
        $this->_addButtonLabel = __('Create New Banner');
        parent::_construct();
    }
}
