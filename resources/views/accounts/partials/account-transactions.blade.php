<table class="table table-striped table-responsive-sm">
    <thead class="thead-light">
        <tr>
            <th>@lang('accounts.date')</th>
            <th>@lang('accounts.reference')</th>
            <th>@lang('accounts.debit')</th>
            <th>@lang('accounts.credit')</th>
            <th>@lang('accounts.balance')</th>
        </tr>
    </thead>
    <tbody>
        @if ($transactions->isEmpty())
            <tr>
                <td>{{ date('d-M', strtotime($account->created_at)) }}</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>{{ $account->balance }}</td>
            </tr>
        @else
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ date('d-M', strtotime($transaction->created_at)) }}</td>
                    <td>{{ $transaction->reference }}</td>
                    <td>{{ $transaction->debit ?? '-' }}</td>
                    <td>{{ $transaction->credit ?? '-' }}</td>
                    <td>{{ $transaction->balance }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
