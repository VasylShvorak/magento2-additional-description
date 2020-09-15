<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Api;

interface SetAdditionalDescriptionInterface
{

    /**
     * Save Additional Description of product
     * @param int $productId
     * @param string $description
     */
    public function execute(int $productId, $description): void;
}
