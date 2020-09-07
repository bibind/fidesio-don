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
            isDisplayedDiscountTotal: function () {
                return true;
            },
            getDiscountTotal: function () {
                var price = 56;
                return 45;
            }
        });
    }
);
