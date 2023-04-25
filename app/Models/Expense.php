<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Constants\ExpenseConstant;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = ExpenseConstant::TABLE_NAME;
}
