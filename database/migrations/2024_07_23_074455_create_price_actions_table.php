<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('price_actions', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('series');
            $table->date('market_date');
            $table->float('pre_closed_price');
            $table->float('open_price');
            $table->float('closed_price');
            $table->float('high_price');
            $table->float('low_price');
            $table->float('change');
            $table->float('change_in_cent');
            $table->float('upper_shadow');
            $table->float('lower_shadow');
            $table->float('trade_qnty');
            $table->float('turnover');
            $table->float('del_trade_qnty');
            $table->integer('del_percent');
            $table->float('no_of_trades');
            $table->float('52_week_low');
            $table->float('52_week_high');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_actions');
    }
};
