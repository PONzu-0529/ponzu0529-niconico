<?php

namespace App\Models;

class AutoGeneratorRequest extends BaseModel
{
    public const TABLE_NAME = 'auto_generator_requests';

    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const MYLIST_TITLE = 'mylist_title';
    public const STATE = 'state';
}
