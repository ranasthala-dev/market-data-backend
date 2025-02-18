<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'series',
        'pre_closed_price',
        'market_date',
        'open_price',
        'closed_price',
        'high_price',
        'low_price',
        'change_in_cent',
        'lower_shadow',
        'upper_shadow',
        'trade_qnty',
        'turnover',
        'del_trade_qnty',
        'del_percent',
        'no_of_trades',
        'change',
        '52_week_low',
        '52_week_high'
    ];
}
