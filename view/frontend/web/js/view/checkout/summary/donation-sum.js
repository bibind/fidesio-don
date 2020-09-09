define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'
    ],
    function ($, Component, quote, totals, priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Fidesio_Donation/checkout/summary/donation-sum'
            },
            totals: quote.getTotals(),
            isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,
            isDisplayedDiscountTotal: function () {
                return true;
            },
            getDiscountTotal: function () {
                var price = 56;
                console.log('segment discount')
                console.log(this.totals())
                console.log('segment donation amount')
                console.log(totals.getSegment('donation_amount').value)
                console.log(totals)
                console.log('quote')
                console.log(quote)

                return  totals.getSegment('donation_amount').value;
            }
        });
    }
);
