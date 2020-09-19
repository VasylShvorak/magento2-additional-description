<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Shvorak\ProductAdditionalDescription\Api\SetAdditionalDescriptionInterface;
use Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescription;
use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\Catalog\Model\ProductFactory;

class ProductPlugin
{
    /**
     * @var SetAdditionalDescriptionInterface
     */
    private $setAdditionalDescription;

    /**
     * @var GetAdditionalDescription
     */
    private $getAdditionalDescription;

    /**
     * @var $productExtensionFactory
     */
    private $productExtensionFactory;

    /**
     * @var $productFactory
     */
    private $productFactory;

    /**
     * @param SetAdditionalDescriptionInterface $setAdditionalDescription
     * @param GetAdditionalDescription $getAdditionalDescription
     * @param ProductExtensionFactory $productExtensionFactory
     * @param ProductFactory $productFactory
     */
    public function __construct(
        SetAdditionalDescriptionInterface $setAdditionalDescription,
        GetAdditionalDescription $getAdditionalDescription,
        ProductExtensionFactory $productExtensionFactory,
        ProductFactory $productFactory
    ) {
        $this->setAdditionalDescription = $setAdditionalDescription;
        $this->getAdditionalDescription = $getAdditionalDescription;
        $this->productFactory = $productFactory;
        $this->productExtensionFactory = $productExtensionFactory;
    }


    /**
     * Around get product by id plugin
     *
     * @param ProductRepositoryInterface $subject
     * @param \Closure $proceed
     * @param int $customerId
     * @return mixed
     */
    public function aroundGetById(ProductRepositoryInterface $subject, \Closure $proceed, $customerId)
    {
        $product = $proceed($customerId);

        $productExtensionAttributes = $product->getExtensionAttributes();
        //if extension attribute is already set, return early.
        if ($productExtensionAttributes && $productExtensionAttributes->getAdditionalDescription()) {
            return $product;
        }

        //In the event that extension attribute class has not be instantiated yet, we create it ourselves.
        if (!$product->getExtensionAttributes()) {
            $productExtension = $this->productExtensionFactory->create();
            $product->setExtensionAttributes($productExtension);
        }

        //Fetch the raw product model, and set the data onto our attribute.
        $productId=$product->getId();
        $additionalDescription = $this->getAdditionalDescription->execute($productId);

        if ($additionalDescription) {
            $value = $additionalDescription['additional_description'];
            $product->getExtensionAttributes()->setAdditionalDescription($value);
        }
        return $product;
    }
}
