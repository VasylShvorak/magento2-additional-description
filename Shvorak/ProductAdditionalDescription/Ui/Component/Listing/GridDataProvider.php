<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Ui\Component\Listing;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList\Collection;
use Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList\CollectionFactory;

class GridDataProvider extends AbstractDataProvider
{

    /**
     * CustomDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ){
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collectionFactory = $collectionFactory;
        $this->collection = $this->collectionFactory->create();
        $this->request = $request;
    }

    /**
     * Get data
     * @return array
     */
    public function getData()
    {
        $this->collection->addEntityFilter($this->request->getParam('current_product_id', 0));

        $arrItems = [
            'totalRecords' => $this->collection->getSize(),
            'items' => [],
        ];

        $data = $this->collection->getData();

        foreach ($data as $item) {
            $arrItems['items'][] = $item;
        }

        return $arrItems;
    }
}
