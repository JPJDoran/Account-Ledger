<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

// Models
use App\Models\Account;
use App\Models\Withdrawal;
use App\Models\Deposit;

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
        $transactions = Auth::user()->Transactions->sortByDesc('created_at')->paginate(15);
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

        return view('accounts.partials.account-summary', compact('account', 'status', 'summaryText'))->render();
    }

    public function newTransaction(Request $request) {
        if (!IS_AJAX) {
            abort('404');
        }

        $validate = Validator::make($request->all(), [
            'reference'     => 'required|max:255|string',
            'amount'        => 'required|between:0,999999999.99',
            'date'          => 'required',
            'transaction'   => 'required'
        ]);

        if (!$validate->passes()) {
			return response()->json(['error' => true, 'validation' => $validate->errors(), 'message' => __('accounts.transaction-error')]);
        }

        $account = Account::find($request->account_id);

        // Account not found, so error out
        if (!$account) {
            return response()->json(['error' => true, 'message' => __('accounts.account-not-found')]);
        }

        // Account doesn't belong to user, so error out
        if ($account->user_id != Auth::id()) {
            return response()->json(['error' => true, 'message' => __('accounts.account-owner-mismatch')]);
        }

        $overdraft = $account->overdraft ?? 0;

        $transaction = [
            'account_id' => $request->account_id,
            'user_id' => Auth::id(),
            'reference' => $request->reference,
            'amount' => $request->amount,
            'date' => date('Y-m-d H:i:s', strtotime($request->date))
        ];

        // -1 = debit, otherwise credit
        if ($request->transaction == -1) {
            $newBalance = $account->balance - $request->amount;

            if ($newBalance < 0 && $overdraft == 0) {
                return response()->json(['error' => true, 'message' => __('accounts.no-overdraft')]);
            }

            if ($newBalance < ($overdraft * -1)) {
                return response()->json(['error' => true, 'message' => __('accounts.overdraft-exceeded')]);
            }

            $transaction['balance'] = $newBalance;

            Withdrawal::create($transaction);
        } else {
            $transaction['balance'] = $account->balance + $request->amount;

            Deposit::create($transaction);
        }

        // Update account balance
        $account->balance = $transaction['balance'];
        $account->save();

        return response()->json(['error' => false]);
    }

    public function getAccountDetailsAjax(Request $request) {
        if (!IS_AJAX) {
            abort('404');
        }

        $account = false;

        if (!is_null($accountId = $request->account_id ?? null)) {
            $account = Account::find($accountId);
        }

        // If no account returned or account belongs to someone else
        if (!$account || $account->user_id != Auth::id()) {
            return response()->json(['error' => true]);
        }

        $accountDetails = $this->getAccountDetails($account);

        return response()->json(['error' => false, 'html'=> $accountDetails]);
    }
}
