<?php

namespace Fidesio\Donation\Observer;

use Fidesio\Donation\Setup\SchemaInformation;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

/**
 * Class AddDonationToOrderObserver
 */
class AddDonationToOrderObserver implements ObserverInterface
{
    /**
     * Transfer the Simple Note from the quote to the order
     * event sales_model_service_quote_submit_before
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        /* @var $order Order */
        $order = $observer->getEvent()->getOrder();

        /** @var $quote Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        /** @var string $donationAmount */
        $simpleNote = $quote->getData(SchemaInformation::ATTRIBUTE_DONATION_AMOUNT);

        $order->setData(SchemaInformation::ATTRIBUTE_DONATION_AMOUNT, $donationAmount);
    }
}