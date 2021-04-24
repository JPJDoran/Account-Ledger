<div class="modal fade" id="transaction-modal" tabindex="-1" role="dialog" aria-labelledby="transaction-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transaction-modal-title">@lang('accounts.new-transaction-title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="transaction-error" data-target="transaction-alert">
                    <p class="mb-0 pb-0">@lang('acccounts.transaction.error')</p>
                </div>

                <div class="alert alert-success d-none" role="alert" id="transaction-success" data-target="transaction-alert">
                    <p class="mb-0 pb-0">@lang('acccounts.transaction.success')</p>
                </div>

                <p>@lang('accounts.new-transaction-intro')</p>
                <form id="transaction-form">
                    <input type="hidden" name="account_id">

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="transaction-select">@lang('accounts.transaction')</label>
                                <select class="form-control" name="transaction" id="transaction-select">
                                    <option value="-1">Debit</option>
                                    <option value="1">Credit</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="transaction-reference">@lang('accounts.reference')</label>
                                <input type="text" class="form-control" name="reference" id="transaction-reference" maxlength="255" placeholder="@lang('accounts.reference-placeholder')" required>

                                <span class="help-block d-none" data-target="reference-errors">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="transaction-amount">@lang('accounts.amount')</label>
                                <input type="number" step="any" min="0.01" max="999999999.99" class="form-control" name="amount" id="transaction-amount" placeholder="@lang('accounts.amount-placeholder')" required>

                                <span class="help-block d-none" data-target="amount-errors">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="transaction-amount">@lang('accounts.date')</label>
                                <input type="datetime-local" class="form-control" name="date" id="transaction-date" value="{{ date('Y-m-d H:i:s') }}" required>

                                <span class="help-block d-none" data-target="date-errors">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="transaction-form">@lang('accounts.save')</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">@lang('accounts.close')</button>
            </div>
        </div>
    </div>
</div>
