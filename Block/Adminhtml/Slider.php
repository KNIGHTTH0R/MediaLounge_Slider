<?php

namespace MediaLounge\Slider\Block\Adminhtml;

class Slider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'MediaLounge_Slider';
        $this->_headerText = __('Sliders');
        $this->_addButtonLabel = __('Create New Slider');
        parent::_construct();
    }
}