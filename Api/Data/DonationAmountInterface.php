<?php

namespace Fidesio\Donation\Api\Data;

/**
 * Interface DonationAmountInterface
 */
interface DonationAmountInterface
{
    /**
     * Get Donnation amount
     *
     * @return string
     */
    public function getDonationAmount();

    /**
     * Set Donnation amount
     *
     * @param string $donationAmount
     *
     * @return void
     */
    public function setDonationAmount($donationAmount);
}