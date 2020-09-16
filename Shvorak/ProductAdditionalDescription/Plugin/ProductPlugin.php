<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Shvorak\ProductAdditionalDescription\Api\SetAdditionalDescriptionInterface;
use Shvorak\ProductAdditionalDescription\Model\ResourceModel\GetAdditionalDescription;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
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
     * After get plugin
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $product
    ) {
        $productId=$product->getId();
        $additionalDescription = $this->getAdditionalDescription->execute($productId);
        $extensionAttributes = $product->getExtensionAttributes(); /** get current extension attributes from entity **/
        $extensionAttributes->setAdditionalDescription($additionalDescription);
        $product->setExtensionAttributes($extensionAttributes);
        return $product;
    }

    /**
     * After get list plugin
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductSearchResultsInterface $searchCriteria
     * @return ProductSearchResultsInterface
     */
    public function afterGetList(
        ProductRepositoryInterface $subject,
        ProductSearchResultsInterface $searchCriteria
    ) : ProductSearchResultsInterface {
        $products = [];
        foreach ($searchCriteria->getItems() as $entity) {
            $additionalDescription = $this->getAdditionalDescription->execute($entity->getId());

            $extensionAttributes = $entity->getExtensionAttributes();
            $extensionAttributes->setAdditionalDescription($extensionAttributes);
            $entity->setExtensionAttributes($extensionAttributes);

            $products[] = $entity;
        }
        $searchCriteria->setItems($products);
        return $searchCriteria;
    }

    /**
     * After save plugin
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product
    ) {
        if ($this->currentProduct !== null) {
            $productId = $this->currentProduct->getId();
            /** @var ProductInterface $currentProduct */
            $extensionAttributes = $this->currentProduct->getExtensionAttributes();

            if ($extensionAttributes && $extensionAttributes->getAdditionalDesciption()) {
                $this->setAdditionalDescription->execute($productId);
            }
        }

        return $product;
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

        $value =$additionalDescription['additional_description'];
        $product->getExtensionAttributes()->setAdditionalDescription($value);

        return $product;
    }
}
