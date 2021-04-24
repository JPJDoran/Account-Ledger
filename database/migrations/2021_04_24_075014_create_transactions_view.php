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
          withdrawals.user_id as user_id,
          withdrawals.reference as reference,
          withdrawals.amount as amount,
          withdrawals.date as date,
          withdrawals.balance as balance,
          'withdrawal' as type
          FROM withdrawals
          UNION
          SELECT deposits.id as id,
          deposits.user_id as user_id,
          deposits.reference as reference,
          deposits.amount as amount,
          deposits.date as date,
          deposits.balance as balance,
          'deposit' as type
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
