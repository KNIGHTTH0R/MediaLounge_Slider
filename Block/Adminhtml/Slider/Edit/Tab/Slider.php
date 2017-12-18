<?php

namespace MediaLounge\Slider\Block\Adminhtml\Slider\Edit\Tab;

class Slider extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Status options
     *
     * @var \MediaLounge\Slider\Model\Slider\Source\Status
     */
    protected $_statusOptions;

    /**
     * @var \MediaLounge\Slider\Model\Slider\Source\Animation
     */
    protected $_animationOptions;

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * constructor
     *
     * @param \MediaLounge\Slider\Model\Slider\Source\Status $_statusOptions
     * @param \MediaLounge\Slider\Model\Slider\Source\Animation $_animationOptions
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \MediaLounge\Slider\Model\Slider\Source\Status $_statusOptions,
        \MediaLounge\Slider\Model\Slider\Source\Animation $_animationOptions,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
    
        $this->_statusOptions = $_statusOptions;
        $this->_animationOptions = $_animationOptions;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \MediaLounge\Slider\Model\Slider $slider */
        $slider = $this->_coreRegistry->registry('medialounge_slider_slider');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Slider Information'),
                'class'  => 'fieldset-wide'
            ]
        );
        if ($slider->getId()) {
            $fieldset->addField(
                'slider_id',
                'hidden',
                ['name' => 'slider_id']
            );
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name'  => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'store_ids',
            'multiselect',
            [
                'name'     => 'store_ids[]',
                'label'    => __('Store Views'),
                'title'    => __('Store Views'),
                'required' => true,
                'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name'  => 'status',
                'label' => __('Status'),
                'title' => __('Status'),
                'values' => array_merge(['' => ''], $this->_statusOptions->toOptionArray()),
            ]
        );

        $fieldset->addField(
            'animation_type',
            'select',
            [
                'name'  => 'animation_type',
                'label' => __('Animation Type'),
                'title' => __('Animation Type'),
                'values' => array_merge(['' => ''], $this->_animationOptions->toOptionArray()),
            ]
        );

        $fieldset->addField(
            'speed',
            'text',
            [
                'name'  => 'speed',
                'label' => __('Animation Speed'),
                'title' => __('Animation Speed'),
            ]
        );

        $fieldset->addField(
            'fade',
            'select',
            [
                'name'  => 'fade',
                'label' => __('Fade'),
                'title' => __('Fade'),
                'values' => ['' => __('-- Please Select --'), '1' => __('Yes'), '0' => __('No')],
            ]
        );

        $fieldset->addField(
            'pause_on_hover',
            'select',
            [
                'name'  => 'pause_on_hover',
                'label' => __('Pause On Hover'),
                'title' => __('Pause On Hover'),
                'values' => ['' => __('-- Please Select --'), '1' => __('Yes'), '0' => __('No')],
            ]
        );


        $sliderData = $this->_session->getData('medialounge_slider_slider_data', true);
        if ($sliderData) {
            $slider->addData($sliderData);
        } else {
            if (!$slider->getId()) {
                $slider->addData($slider->getDefaultValues());
            }
        }
        $form->addValues($slider->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Slider');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
