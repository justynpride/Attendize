<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSquareGateway extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $square = DB::table('payment_gateways')->where('name', '=', 'Square')->first();
        if ($square === null) {
            DB::table('payment_gateways')->insert(
                [
                    'provider_name' => 'Square',
                    'provider_url' => 'https://www.squareup.com',
                    'is_on_site' => 1,
                    'can_refund' => 1,
                    'name' => 'Square',
                    'default' => 0,
                    'admin_blade_template' => 'ManageAccount.Partials.Square',
                    'checkout_blade_template' => 'Public.ViewEvent.Partials.PaymentSquare'
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
