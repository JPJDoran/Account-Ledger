<table class="table table-bordered table-striped table-responsive-sm">
    <thead class="thead-light">
        <tr>
            <th>@lang('accounts.date')</th>
            <th>@lang('accounts.reference')</th>
            <th>@lang('accounts.debit')</th>
            <th>@lang('accounts.credit')</th>
            <th>@lang('accounts.balance')</th>
            <th>@lang('accounts.added')</th>
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
                <td>{{ date('d-M', strtotime($account->created_at)) }}</td>
            </tr>
        @else
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ date('d-M-y', strtotime($transaction->date)) }}</td>
                    <td>{{ $transaction->reference }}</td>
                    <td>{{ number_format($transaction->debit, 2) }}</td>
                    <td>{{ number_format($transaction->credit, 2) }}</td>
                    <td>{{ number_format($transaction->balance, 2) }}</td>
                    <td>{{ date('d/m/Y H:i:s', strtotime($transaction->created_at)) }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@if (!$transactions->isEmpty())
    <div class="row justify-content-center">
        <div class="col-auto">
            {{ $transactions->links() }}
        </div>
    </div>
@endif
