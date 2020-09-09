<?php

namespace  Fidesio\Donation\Api;

/**
 * Interface for saving the checkout donation amount to the quote for orders
 *
 * @api
 */
interface DonationAmountManagementInterface
{
    /**
     * @param int $cartId
     * @param \Fidesio\Donation\Api\Data\DonationAmountInterface $donationAmount
     *
     * @return string
     */
    public function saveSimpleNote(
        $cartId,
        \Atwix\SimpleNote\Api\Data\SimpleNoteInterface $donationAmount
    );
}