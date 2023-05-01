<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Constants\PaymentModelConstant;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = PaymentModelConstant::TABLE_NAME;
}
