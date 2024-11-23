<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransferDetail extends Model
{
    protected $table = 'bank_transfer_details';

    protected $fillable = [
        'user_id', 'account_name', 'bank_name', 'bank_account', 'is_active', 'is_default'
    ];

}