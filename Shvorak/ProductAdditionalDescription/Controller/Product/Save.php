<?php


namespace Shvorak\ProductAdditionalDescription\Controller\Product;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Shvorak\ProductAdditionalDescription\Api\SetAdditionalDescriptionInterface;



class Save extends Action
{
    /**
     * @var SetAdditionalDescriptionInterface
     */
    private $setDescription;

    /**
     * Save constructor.
     * @param Context
     * @param SetAdditionalDescriptionInterface
     */
    public function __construct(
        Context $context,
        SetAdditionalDescriptionInterface $setDescription
    )
    {
        parent::__construct($context);
        $this->setDescription = $setDescription;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $description = $this->getRequest()->getPostValue('additional_description');
        $productId = (int)$this->getRequest()->getParam('id');
        $this->setDescription->execute($productId,$description);
        //TODO: check if data passed from form
        //and redirect to current page
        return $resultRedirect->setPath('/');

    }
}