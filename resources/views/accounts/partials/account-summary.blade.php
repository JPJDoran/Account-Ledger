<div class="alert alert-{{ $status }} mb-0" role="alert">
    <h3>@lang('accounts.balance'): {{ number_format($account->balance, 2) }}</h3>
    <p class="mb-0 pb-0">{{ $summaryText }}</p>

    <hr>

    @if (!is_null($account->overdraft))
        <p class="mb-0 pb-0">@lang('accounts.overdraft-limit'): {{ number_format($account->overdraft, 2) }}</p>
    @else
        <p class="mb-0 pb-0">@lang('accounts.no-overdraft')</p>
    @endif
</div>
