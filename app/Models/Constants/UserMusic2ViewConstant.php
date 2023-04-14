<?php

namespace App\Models\Constants;

use App\Models\Constants\MusicConstant;
use App\Models\Constants\UserMusicConstant;
use App\Models\Constants\MusicMemoConstant;

class UserMusic2ViewConstant
{
    public const VIEW_NAME = 'user_music_2_view';

    public const MUSIC_ID = 'music_id';
    public const TITLE = MusicConstant::TITLE;
    public const NICONICO_ID = MusicConstant::NICONICO_ID;
    public const USER_ID = 'user_id';
    public const FAVORITE = UserMusicConstant::FAVORITE;
    public const SKIP = UserMusicConstant::SKIP;
    public const MEMO = MusicMemoConstant::MEMO;
}
