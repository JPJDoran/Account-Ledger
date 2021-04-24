<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW transactions AS
        (
          SELECT withdrawals.id as id,
          withdrawals.account_id as account_id,
          withdrawals.user_id as user_id,
          withdrawals.reference as reference,
          withdrawals.amount as debit,
          null as credit,
          withdrawals.date as date,
          withdrawals.balance as balance,
          withdrawals.created_at as created_at
          FROM withdrawals
          UNION
          SELECT deposits.id as id,
          deposits.account_id as account_id,
          deposits.user_id as user_id,
          deposits.reference as reference,
          null as debit,
          deposits.amount as credit,
          deposits.date as date,
          deposits.balance as balance,
          deposits.created_at as created_at
          FROM deposits
        )"
      );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW transactions");
    }
}
