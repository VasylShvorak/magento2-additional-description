<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;

/**
 * Get additional_description attribute from database
 */
class GetAdditionalDescription
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
     *  Get addditional_description record by Product id.
     *
     * @param int $productId
     * @return bool
     */
    public function execute($productId)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('shvorak_additional_description');

        $select = $connection->select()
            ->from(
                $tableName
            )
            ->where('product_id = ?', $productId);

        return $connection->fetchRow($select);
    }
}
