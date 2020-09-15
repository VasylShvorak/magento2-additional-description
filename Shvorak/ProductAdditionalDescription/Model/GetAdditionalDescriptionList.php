<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Model;

use Magento\Framework\Model\AbstractModel;
use Shvorak\ProductAdditionalDescription\Api\GetAdditionalDescriptionListInterface;

class GetAdditionalDescriptionList extends AbstractModel implements GetAdditionalDescriptionListInterface
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList');
    }
}
