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

namespace Fidesio\Donation\Block\Checkout;

use Fidesio\Donation\Helper\Data as DonationHelper;
use Fidesio\Donation\Block\Donation\ListProductFactory as DonationProductsFactory;

/**
 * Class LayoutProcessor
 * @package Fidesio\Donation\Block\Checkout
 */
class LayoutProcessor implements \Magento\Checkout\Block\Checkout\LayoutProcessorInterface
{

    /**
     * @var DonationHelper
     */
    private $donationHelper;

    /**
     * @var \Fidesio\Donation\Block\Donation\ListProduct
     */
    private $donationProductsFactory;

    /**
     * LayoutProcessor constructor.
     * @param DonationHelper $donationHelper
     * @param DonationProducts $donationProducts
     */
    public function __construct(
        DonationHelper $donationHelper,
        DonationProductsFactory $donationProductsFactory
    ) {
        $this->donationHelper = $donationHelper;
        $this->donationProductsFactory = $donationProductsFactory;
    }

    /**
     * @param array $result
     * @return array
     */
    public function process($result)
    {

        if (isset($result['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['afterMethods']['children'])) {
            $result['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['afterMethods']['children']['fidesio-donation'] = $this->getDonationForm('checkout.donation.block');
        }


        return $result;
    }

    /**
     * @param $scope
     * @return array
     */
    public function getDonationForm($nameInLayout)
    {
        $donationBlock = $this->getLayout()->createBlock(
            'Magento\Cms\Block\Block'
        );
        $donationBlock->setTemplate('donationblock.phtml');
        $donationBlock->setNameInLayout($nameInLayout);
        $donationBlock->setAjaxRefreshOnSuccess(true);

        $content = $donationBlock->toHtml();
        $content .= "<script type=\"text/javascript\">jQuery('body').trigger('contentUpdated');</script>";

        $donationForm =
            [
                'component' => 'Magento_Ui/js/form/components/html',
                'config' => [
                    'content'=> $content
                ]
            ];

        return $donationForm;
    }
}
