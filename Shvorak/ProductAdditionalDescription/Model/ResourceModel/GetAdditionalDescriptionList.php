<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GetAdditionalDescriptionList extends AbstractDb
{
    /**
     * Initialize collection
     */
    protected function _construct()
    {
        $this->_init('shvorak_additional_description', 'product_id');
    }
}
