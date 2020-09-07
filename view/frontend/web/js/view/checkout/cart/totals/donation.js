define(
    [
       'Fidesio_Donation/js/view/checkout/summary/donation-sum'
],
function (Component) {
    'use strict';
    return Component.extend({
        /**
         * @override
         */
        isDisplayed: function () {
            return true;
        }
    });
}
);
