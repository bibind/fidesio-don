define([
    "jquery",
    'mage/translate',
    'ko',
    "mage/storage",
    "mage/validation",
    "uiComponent",
    'Magento_Checkout/js/action/get-totals',

], function ($, $t, ko, storage, validation, Component, getTotalsAction) {

    $.widget('mage.donation', {

        _create: function () {
            this.initDonationModal();
        },

        initDonationModal: function () {

            var self = this;

            var options = {
                type: 'popup',
                title: 'Donation',
                responsive: true,
                innerScroll: true,
                modalClass: 'fidesio_donation-modal-popup',
                buttons: []
            }
            $('html').on('change', '#fidesio-donation-checkbox', function () {

                if (this.checked) {
                    $('.fidesio-donation-block-wrapper').addClass('visibleDonation')

                }
                if (!this.checked) {
                    $('.fidesio-donation-block-wrapper').removeClass('visibleDonation')
                }


            });

            $('html').on('change', this.options.SelectAmount, function () {
                var select = jQuery(this);
                console.log(select.val());
                self.initAjaxCart()
            });

        },

        initAjaxCart: function() {
            var self = this;

            $.ajax({
                type: "POST",
                url: jQuery(self.options.addDonationFormId).attr('action'),
                data: jQuery(self.options.addDonationFormId).serialize(),
                showLoader: true,
                success: function(response) {
                    self.clearMessages();
                    if (response.success) {
                        console.log(response);
                        console.log('dddd deferred')
                        var deferred = $.Deferred();
                        getTotalsAction([], deferred);
                        self.addMessage(response.success, 'success');
                    }
                    if (response.error) {
                        console.log(response)
                    }
                    if(response.success && self.options.setAjaxRefreshOnSuccess) {
                        console.log(response)
                        console.log('ffff')
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                }
            });


        },

        clearMessages: function() {
            $(this.options.addDonationFormId + ' .message').remove();
        },

        addMessage: function(message, type) {
            if (this.options.setAjaxRefreshOnSuccess) {
                message = message + ' ' + this.options.setAjaxRefreshOnSuccessMsg
            }
            var messageHtml = '<div class="message">' +
                '<div class="message '+ type +'">' + message + '</div>' +
                '</div>';
            $(this.options.addDonationFormId).prepend(messageHtml);
        },

        resetRadioButtons: function () {
            $(this.options.inputRadioSelector).attr('checked', false);
        },

        addFormValidation: function () {
            var addtoCartForm = $(this.options.addDonationFormId);
            addtoCartForm.mage('validation', {});
        }

    });

    return $.mage.donation;
});