<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Constants\UserMusic2ViewConstant;

class UserMusic2View extends Model
{
    use HasFactory;

    protected $table = UserMusic2ViewConstant::VIEW_NAME;
}
