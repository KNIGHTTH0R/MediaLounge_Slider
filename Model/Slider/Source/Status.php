<?php

namespace MediaLounge\Slider\Model\Slider\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    const ENABLED = 1;
    const DISABLE = 2;


    /**
     * to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            ['label' => __('-- Please Select --'), 'value' => ''],
            ['label' => __('Enabled'), 'value' => self::ENABLED],
            ['label' => __('Disable'), 'value' => self::DISABLE],
        ];

        return $options;
    }
}
