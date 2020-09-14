<?php


namespace Shvorak\ProductAdditionalDescription\Model;

use Magento\Framework\Model\AbstractModel;
use Shvorak\ProductAdditionalDescription\Api\GetAdditionalDescriptionListInterface;

class GetAdditionalDescriptionList extends AbstractModel implements GetAdditionalDescriptionListInterface
{
    protected function _construct()
    {
        $this->_init('Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescriptionList');
    }
}