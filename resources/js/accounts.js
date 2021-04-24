let token;

$(document).ready(function() {
    token = $('html').find('meta[name="csrf-token"]').attr('content');

    // On change of account reload account details
    $('#account-select').on('change', function() {

    });

    // On open of the new transaction modal, set hidden account it field
    $('body').on('click tap', '[data-target="#transaction-modal"]', function() {
        let id = $('#account-select').val();
        $('#transaction-form').find('input[name="account_id"]').val(id);
    });

    // On modal close reset the form and the messages
    $('#transaction-modal').on('hidden.bs.modal', function (event) {
        // Reset the form
        $('#transaction-form').trigger('reset');

        // Hide existing messages
        $('body').find('[data-target="transaction-alert"]').addClass('d-none');
        $('body').find('.help-block').addClass('d-none');
    });

    // On new transaction form submit, attempt to add transaction
    $('#transaction-form').on('submit', function(event) {
        event.preventDefault();

        let $alert;
        let $validation;
        let form = document.getElementById('transaction-form');
        let formData = new FormData(form);

        // Hide existing messages
        $('body').find('[data-target="transaction-alert"]').addClass('d-none');
        $('body').find('.help-block').addClass('d-none');

        $.ajax({
            url: '/accounts/addTransaction',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': token
            }
        }).done(function(data) {
            if (data.error) {
                // Show errors
                $alert = $('#transaction-error');
                $alert.find('p').html(data.message);

                if (data.hasOwnProperty('validation')) {
                    $.each(data.validation, function(index, val) {
                        $validation = $('body').find(`[data-target="${index}-errors"]`);
                        $validation.find('strong').html(val);
                        $validation.removeClass('d-none');
                    });
                }

                $alert.removeClass('d-none');

                return;
            }

            // Show Success
            $alert = $('#transaction-success');
            $alert.removeClass('d-none');

            // reload transactions
            refreshTransactions();
        });
    });
});

function refreshTransactions() {
    let account_id = $('#account-select').val();
    let $accountContainer = $('#account-container');
    let $spinner = $('#loading-spinner');

    $accountContainer.addClass('d-none');
    $spinner.removeClass('d-none');

    $.ajax({
        url: '/accounts/getAccountDetailsAjax',
        type: 'POST',
        dataType: 'JSON',
        data : { account_id },
        headers: {
            'X-CSRF-TOKEN': token
        }
    }).done(function(data) {
        if (data.error) {
            // Ajax update of content failed so refresh full page instead
            location.reload();
            return;
        }

        // Update content
        $accountContainer.html(data.html);
        $spinner.addClass('d-none');
        $accountContainer.removeClass('d-none');

        // Close modal
        $('#transaction-modal').modal('hide');
    });
}
