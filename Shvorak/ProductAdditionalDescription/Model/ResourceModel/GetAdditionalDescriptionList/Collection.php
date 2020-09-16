<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Shvorak\ProductAdditionalDescription\Model\GetAdditionalDescriptionList;
use Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList as ResourceModel;

/**
 * Return collection with additional description values
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize model and resource model
     */
    protected function _construct()
    {
        $this->_init(
            GetAdditionalDescriptionList::class,
            ResourceModel::class
        );
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
