<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiatInfo extends Model
{
    const FIAT_USD = "USD";
    const FIAT_VND = "VND";

    protected $table = 'fiat_infos';

    protected $fillable = [
        'name', 'description', 'currency', 'decimals'
    ];
}
