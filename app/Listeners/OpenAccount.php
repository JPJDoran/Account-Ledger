<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Models
Use App\Models\Account;
Use App\Models\Deposit;

class OpenAccount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event) {
        // On registration open a new bank account
        $accountId = Account::create([
            'user_id' => $event->user->id
        ])->id;

        // Get the created account
        $account = Account::find($accountId);

        // Input first deposit log
        Deposit::create([
            'account_id' => $accountId,
            'user_id' => $event->user->id,
            'reference' => 'Opening Balance',
            'amount' => $account->balance,
            'date' => date('Y-m-d H:i:s'),
            'balance' => $account->balance,
        ]);
    }
}
