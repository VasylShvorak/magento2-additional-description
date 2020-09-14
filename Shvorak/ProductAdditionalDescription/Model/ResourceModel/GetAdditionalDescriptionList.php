<?php


namespace Shvorak\ProductAdditionalDescription\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;


class GetAdditionalDescriptionList extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('shvorak_additional_description', 'product_id');
    }
}