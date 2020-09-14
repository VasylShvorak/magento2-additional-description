<?php


namespace Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Shvorak\ProductAdditionalDescription\Model\GetAdditionalDescriptionList','Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList');
    }

    /**
     * Add entity filter
     *
     * @param int $entityId
     * @return $this
     */
    public function addEntityFilter($entityId)
    {
        $this->getSelect()->where('product_id = ?', $entityId);
        return $this;
    }


}