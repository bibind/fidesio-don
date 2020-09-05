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

namespace Fidesio\Donation\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Fidesio\Donation\Helper
 */
class Data extends AbstractHelper
{

    const DONATION_CONFIGURATION_FIXED_AMOUNTS = 'fidesio_donation/general/fixed_amounts';

    const DONATION_CONFIGURATION_TITLE = 'fidesio_donation/general/donation_titre';

    const DONATION_CONFIGURATION_DESCRIPTION = 'fidesio_donation/general/description_donantion';

    const DONATION_CONFIGURATION_IMAGE = 'fidesio_donation/imagedonation/imagedonation';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Data constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;

        parent::__construct($context);
    }

    /**
     * @return array
     */
    public function getDetailsBlockDonation()
    {
        $detailsBlockDonation = [];
        $detailsBlockDonation['title'] = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_TITLE,
            ScopeInterface::SCOPE_STORE
        );
        $detailsBlockDonation['description'] = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_DESCRIPTION,
            ScopeInterface::SCOPE_STORE
        );
        $detailsBlockDonation['image'] = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_IMAGE,
            ScopeInterface::SCOPE_STORE
        );

        return $detailsBlockDonation;
    }

    /**
     * @return array
     */
    public function getFixedAmounts()
    {
        $fixedAmountsConfig = [5,10,15,25,50];

        $config = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_FIXED_AMOUNTS,
            ScopeInterface::SCOPE_STORE
        );

        if ($config) {
            $fixedAmountsConfig = explode(',', $config);
        }

        $fixedAmounts = [];
        foreach ($fixedAmountsConfig as $fixedAmount) {
            $fixedAmounts[$fixedAmount] = $this->getCurrencySymbol() . ' ' . $fixedAmount;
        }
        return $fixedAmounts;
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return (string) $this->storeManager->getStore()->getCurrentCurrency()->getCurrencySymbol();
    }






}
