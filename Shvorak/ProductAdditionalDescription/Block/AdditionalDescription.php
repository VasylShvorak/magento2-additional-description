<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Block;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\View;
use Magento\Customer\Model\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Customer\Model\Session;

class AdditionalDescription extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var HttpContext
     */
    private $httpContext;

    /**
     * AdditionalDescription constructor.
     * @param Template\Context $context
     * @param HttpContext $httpContext
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        HttpContext $httpContext,
        Session $customerSession,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->httpContext = $httpContext;
        $this->customerSession = $customerSession;
    }

    /**
     * Add product id to url params
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl(
            'shvorak_description/product/save',
            [
                'id' => $this->getProductId(),
            ]
        );
    }

    /**
     * Check if customer is logged in
     * @return mixed|null
     */
    public function isCustomerLoggedIn()
    {
       return $this->httpContext->getValue(CustomerContext::CONTEXT_AUTH);
    }

    /**
     * Verify if customer is allowed to add addtional description
     * @return mixed
     */
    public function isAdditionalDescriptionAllowed()
    {
        return $this->customerSession->getCustomer()->getAddDescription();
        //return $this->customerSession->getCustomerId();
    }

    /**
     * Get review product id
     *
     * @return int
     */
    protected function getProductId()
    {
        return $this->getRequest()->getParam('id', false);
    }
}
