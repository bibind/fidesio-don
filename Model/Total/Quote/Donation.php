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

namespace Fidesio\Donation\Model\Total\Quote;

/**
 * Class Donation
 * @package Fidesio\Donation\Model\Total\Quote
 */
class Donation extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * Custom constructor.
     */
    public function __construct()
    {
        $this->setCode('donation_amount');
   }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     *
     * @return $this|\Magento\Quote\Model\Quote\Address\Total\AbstractTotal
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);


        //$quote->setDonationAmount(64);
        if(is_int($quote->getDonationAmount())){
            $total->setTotalAmount('donation_amount', $quote->getDonationAmount());
            $total->setBaseTotalAmount('donation_amount', $quote->getDonationAmount());
            $total->setDonationAmount($quote->getDonationAmount());
            $total->setBaseDonationAmount($quote->getDonationAmount());
            $total->setGrandTotal($total->getGrandTotal() + $quote->getDonationAmount());
            $total->setBaseGrandTotal($total->getBaseGrandTotal() + $quote->getDonationAmount());
        }




        return $this;
    }

    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     *
     * @return array
     */
    public function fetch(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        $donationamount = $quote->getDonationAmount();
        if(!$donationamount){
            $donationamount = 0;
        }
        return [
            'code'  => 'donation_amount',
            'title' => $this->getLabel(),
            'value' => $donationamount  //You can change the reduced amount, or replace it with your own variable
        ];
    }
}

