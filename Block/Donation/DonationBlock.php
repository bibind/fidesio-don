<?php
/**
 * A Magento 2 module named fidesio/donation
 * Copyright (C) 2017 Houssou audrey-roch
 *
 * This file is part of fidesio/donation.
 *
 * fidesio/donation is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fidesio\Donation\Block\Donation;

use Magento\Framework\View\Element\Template\Context;
use Fidesio\Donation\Helper\Data as DonationHelper;
use Magento\Checkout\Helper\Cart as CartHelper;

/**
 * Class ListProduct
 * @package Fidesio\Donation\Block\Donation
 */
class DonationBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @var DonationHelper
     */
    protected $donationHelper;

    /**
     * ListProduct constructor.
     * @param DonationHelper $donationHelper
     * @param Context $context
     * @param CartHelper $cartHelper
     * @param array $data
     */
    public function __construct(
        DonationHelper $donationHelper,
        Context $context,
        CartHelper $cartHelper,
        array $data = []
    ) {

        $this->donationHelper = $donationHelper;
        $this->cartHelper = $cartHelper;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getDetailDoantionBlock()
    {
        $pageSize = $this->donationHelper->getLimitByBlockName($this->_nameInLayout);

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type_id', 'donation', 'eq')
            ->addFilter('status', 1, 'eq')
            ->setPageSize($pageSize)
            ->setCurrentPage(1)
            ->addSortOrder($this->sortOrder->setDirection('DESC')->setField('name'))
            ->create();

        $products = $this->productRepository->getList($searchCriteria);

        $items = $products->getItems();

        shuffle($items);

        return $items;
    }



    /**
     * @param $product
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($product, $additional = [])
    {
        if ($this->isAjaxEnabled()) {
            return $this->getUrl('donation/cart/add', ['product' => $product->getEntityId()]);
        }
        return $this->cartHelper->getAddUrl($product, $additional);
    }


    /**
     * Retrieve product image
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $imageId
     * @param array $attributes
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

    /**
     * @return array
     */
    public function getFixedAmounts()
    {
        return $this->donationHelper->getFixedAmounts();
    }

    /**
     * @return mixed
     */
    public function getCurrencySymbol()
    {
        return $this->donationHelper->getCurrencySymbol();
    }
    
    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return str_replace('.', '-', parent::getNameInLayout());
    }

    /**
     * @return string
     */
    public function getMinimalDonationAmount($product)
    {
        return $this->donationHelper->getCurrencySymbol() . ' ' . $this->donationHelper->getMinimalAmount($product);
    }

    /**
     * @return string
     */
    public function getHtmlValidationClasses($product)
    {
        return $this->donationHelper->getHtmlValidationClasses($product);
    }

    /**
     * @return bool
     */
    public function isAjaxEnabled()
    {
        return true;
    }
}
