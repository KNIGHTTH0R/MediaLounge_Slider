<?php

namespace MediaLounge\Slider\Block;

use \Magento\Framework\View\Element\Template\Context;
use \Magento\Cms\Model\Template\FilterProvider;
use \MediaLounge\Slider\Model\Slider\Source\Animation;
use MediaLounge\Slider\Model\SliderFactory as SliderModelFactory;
use MediaLounge\Slider\Model\BannerFactory as BannerModelFactory;


class Slider extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var SliderModelFactory
     */
    protected $_sliderFactory;

    /**
     * @var BannerModelFactory
     */
    protected $_bannerFactory;

    /**
     * @var Animation
     */
    protected $_animationOptions;

    public function __construct(
        Context $context,
        SliderModelFactory $sliderFactory,
        BannerModelFactory $bannerFactory,
        FilterProvider $filterProvider,
        Animation $animationOptions,
        array $data = []
    )
    {
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerFactory = $bannerFactory;
        $this->_filterProvider = $filterProvider;
        $this->_animationOptions = $animationOptions;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return $this|null
     */
    public function getSlider()
    {
        $sliderId = $this->getSliderId();
        $model = $this->_sliderFactory->create()->load($sliderId); // @todo replace to entity manager
        if ($model && ($model->getStatus() == 1) && $model->isStoreExist($this->_storeManager->getStore()->getId())) {
            return $model;
        } else {
            return null;
        }
    }

    /**
     *
     *
     * @return $this|null
     */
    public function getSlides()
    {
        $slider = $this->getSlider();
        if ($slider) {
            $banners = $slider->getSelectedBannersCollection()
                ->addOrder('position', 'asc');
            return $banners;
        } else {
            return null;
        }
    }

    public function getSliderConfigs()
    {
        $result = [];
        if($slider = $this->getSlider()){
            $result['fade'] = $slider->getData('fade') ? 'true' : 'false';
            $result['autoplaySpeed'] = $slider->getData('speed');
            $result['pauseOnHover'] = $slider->getData('pause_on_hover') ? 'true' : 'false';
            $result['cssEase'] = $this->_animationOptions->getAnimationName($slider->getData('animation_type'));
        }

        return $result;
    }

    /**
     * Create Slider Unique Id
     *
     * @return string
     */
    public function getSliderUniqueId()
    {
        $result = $this->_storeManager->getStore()->getId() . '-';
        if ($this->getSlider()) {
            $result .= $this->getSlider()->getId();
        }

        return $result;
    }

    /**
     * Prepare HTML content
     *
     * @param string $value
     * @return string
     * @throws \Exception
     */
    public function getCmsFilterContent($value = '')
    {
        $html = $this->_filterProvider->getPageFilter()->filter($value);
        return $html;
    }

}