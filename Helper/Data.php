<?php
namespace MediaLounge\Slider\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * get Animation Type
     * @return array
     */
    public function getAnimationType()
    {
        return [
            [
                'label' => __('Slide'),
                'value' => 'slide',
            ],
            [
                'label' => __('Fade'),
                'value' => 'fade',
            ],
        ];
    }
}
