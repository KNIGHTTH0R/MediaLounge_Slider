<?php

namespace MediaLounge\Slider\Model\Slider\Source;

class Animation implements \Magento\Framework\Option\ArrayInterface
{
    const LINEAR = 1;
    const EASY = 2;
    const EASY_IN = 3;
    const EASY_OUT = 4;
    const EASY_IN_OUT = 5;

    /**
     * to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            ['label' => __('-- Please Select --'), 'value' => '']
        ];

        foreach ($this->getOptions() as $key => $option) {
            $options[] = ['label' => __($option), 'value' => $key];
        }

        return $options;
    }

    /**
     * @param $animationId
     * @return mixed|string
     */
    public function getAnimationName($animationId)
    {
        $option = $this->getOptions();
        if ($option[$animationId]) {
            return $option[$animationId];
        } else {
            return $option[self::LINEAR];
        }
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            self::LINEAR => 'linear',
            self::EASY => 'ease',
            self::EASY_IN => 'ease-in',
            self::EASY_OUT => 'ease-out',
            self::EASY_IN_OUT => 'ease-in-out',
        ];
    }
}
