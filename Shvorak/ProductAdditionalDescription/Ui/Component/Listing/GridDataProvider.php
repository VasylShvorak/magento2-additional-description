<?php


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
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
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
        /*return [
            'items' => [
                [
                    'product_id' => 1,
                    'additional_description' => 'First Item'
                ],
                [
                    'product_id' => 2,
                    'additional_description' => 'Second Item'
                ],
                [
                    'product_id' => 3,
                    'additional_description' => 'Third Item'
                ]
            ],
            'totalRecords' => 3
        ];*/
    }

}