<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

    }

    /**
     * Show the account dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        // Get the logged in user's accounts
        $accounts = Auth::user()->Accounts;

        // Something failed in account creation
        if ($accounts->isEmpty()) {
            abort('404');
        }

        // Get the account dropdown partial
        $accountSelect = view('accounts.partials.account-select', compact('accounts'))->render();

        // Get the account details partial
        $accountDetails = $this->getAccountDetails($accounts->first());

        return view('index', compact('accountSelect', 'accountDetails'));
    }

    /**
     * Get the account details including summary and transactions
     * @param  Account $account [The account to be listed]
     * @return string [The corresponding accouint details]
     */
    private function getAccountDetails(Account $account) {
        // Account status - saving goal met, in overdraft etc
        $summary = $this->getAccountSummary($account);

        // Get account transactions
        $transactions = Auth::user()->Transactions->sortByDesc('date');
        $transactions = view('accounts.partials.account-transactions', compact('account', 'transactions'))->render();

        return view('accounts.partials.account-details', compact('summary', 'transactions'))->render();
    }

    /**
     * Get the summary of account standing
     * @param  Account $account [The account to be checked]
     * @return string [The corresponding summary]
     */
    private function getAccountSummary(Account $account) {
        $status = 'secondary';
        $summaryText = __('accounts.normal-balance');

        if ($account->balance >= 4000) {
            $status = 'success';
            $summaryText = __('accounts.saving-balance');
        }

        if ($account->balance < 0) {
            $status = 'danger';
            $summaryText = __('accounts.overdraft-balance');
        }

        return view('accounts.partials.account-summary', compact('status', 'summaryText'))->render();
    }
}
