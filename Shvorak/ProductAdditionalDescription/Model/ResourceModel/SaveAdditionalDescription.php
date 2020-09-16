<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;

class SaveAdditionalDescription
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Save Login as Customer assistance allowed record by Customer id.
     *
     * @param int $productId
     * @param string $description
     * @return void
     */
    public function execute(int $productId, $description): void
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('shvorak_additional_description');
        $connection->insertOnDuplicate(
            $tableName,
            [
                'product_id' => $productId,
                'additional_description' => $description
            ]
        );
    }
}
