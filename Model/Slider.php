<?php

namespace MediaLounge\Slider\Model;

/**
 * @method Slider setName($name)
 * @method Slider setDescription($description)
 * @method Slider setStatus($status)
 * @method mixed getName()
 * @method mixed getStatus()
 * @method Slider setCreatedAt(\string $createdAt)
 * @method string getCreatedAt()
 * @method Slider setUpdatedAt(\string $updatedAt)
 * @method string getUpdatedAt()
 */
class Slider extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'medialounge_slider_slider';

    /**
     * Cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'medialounge_slider_slider';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'medialounge_slider_slider';

    /**
     * Banner Collection
     *
     * @var \MediaLounge\Slider\Model\ResourceModel\Banner\Collection
     */
    protected $bannerCollection;

    /**
     * Banner Collection Factory
     *
     * @var \MediaLounge\Slider\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * constructor
     *
     * @param \MediaLounge\Slider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \MediaLounge\Slider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }


    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MediaLounge\Slider\Model\ResourceModel\Slider');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * get entity default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * @return array|mixed
     */
    public function getBannersPosition()
    {
        if (!$this->getId()) {
            return array();
        }
        $array = $this->getData('banners_position');
        if (is_null($array)) {
            $array = $this->getResource()->getBannersPosition($this);
            $this->setData('banners_position', $array);
        }
        return $array;
    }

    /**
     * @return \MediaLounge\Slider\Model\ResourceModel\Banner\Collection
     */
    public function getSelectedBannersCollection()
    {
        if (is_null($this->bannerCollection)) {
            $collection = $this->bannerCollectionFactory->create();
            $collection->join(
                'medialounge_slider_banner_slider',
                'main_table.banner_id=medialounge_slider_banner_slider.banner_id AND medialounge_slider_banner_slider.slider_id=' . $this->getId(),
                ['position']
            );
            $this->bannerCollection = $collection;
        }
        return $this->bannerCollection;
    }

    /**
     * Getter
     * Explode to array if string setted
     *
     * @return array
     */
    public function getStoreIds()
    {
        if (is_string($this->getData('store_ids'))) {
            return explode(',', $this->getData('store_ids'));
        }
        return $this->getData('store_ids');
    }

    /**
     * Check if store id exist in current slider
     *
     * @param $storeId
     * @return bool
     */
    public function isStoreExist($storeId)
    {
        if (in_array('0', $this->getStoreIds())) {
            return true;
        } else {
            return in_array($storeId, $this->getStoreIds());
        }
    }
}