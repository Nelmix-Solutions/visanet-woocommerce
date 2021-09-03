jQuery(document).ready(function () {
    jQuery('#wc-visanet-form').each(function () {
        var form = jQuery(this);
        var cardNumber = form.find('#card_number');
        var cardNumberMask = form.find('#card_number_mask');
        var expiryDate = form.find('#card_expiry_date');
        var expiryMonth = form.find('#card_expiry_month');
        var expiryYear = form.find('#card_expiry_year');

        cardNumberMask.on('change', updateCardNumber);
        expiryMonth.on('change', updateExpiryDate);
        expiryYear.on('change', updateExpiryDate);

        function updateCardNumber() {
            var number = cardNumberMask.val().replace(/[\- ]/g, '');
            cardNumber.val(number);
        }

        function updateExpiryDate() {
            var month = expiryMonth.val();
            if (month < 10) month = '0' + month;

            var date = month + '-' + expiryYear.val();

            expiryDate.val(date);
        }
    });

    jQuery('#card_number_mask').on('input', function (e) {
        const numberCard = e.target.value;
        const cardType = jQuery('input[name="card_type"]');
        cardType.val('001');

        if (typeof numberCard !== "undefined" && numberCard.trim().length > 0 && numberCard.startsWith('5')) {
            cardType.val('002');
        }
    })
});
