<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Model;

use Shvorak\ProductAdditionalDescription\Api\SetAdditionalDescriptionInterface;
use Shvorak\ProductAdditionalDescription\Model\ResourceModel\SaveAdditionalDescription;

class SetAdditionalDescription implements SetAdditionalDescriptionInterface
{

    /**
     * @param SaveAdditionalDescription $saveAdditionalDescription
     */
    public function __construct(SaveAdditionalDescription $saveAdditionalDescription)
    {
        $this->saveAdditionalDescription = $saveAdditionalDescription;
    }

    /**
     * Save Additional Description of product
     *
     * @param int $productId
     * @param string $description
     */
    public function execute(int $productId, $description): void
    {
        $this->saveAdditionalDescription->execute($productId, $description);
    }
}
