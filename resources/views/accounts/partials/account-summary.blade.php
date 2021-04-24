<div class="alert alert-{{ $status }} mb-0" role="alert">
    <h3>@lang('accounts.balance'): {{ number_format($account->balance, 2) }}</h3>
    <p class="mb-0 pb-0">{{ $summaryText }}</p>
</div>
