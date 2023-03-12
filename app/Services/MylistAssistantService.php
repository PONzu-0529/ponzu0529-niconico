<?php

namespace App\Services;

use Auth;
use App\Models\Music;
use App\Models\UserMusic;
use App\Models\UserMusicView;
use App\Models\Constants\MusicConstant;
use App\Models\Constants\UserMusicConstant;
use App\Models\Constants\UserMusicViewConstant;

class MylistAssistantService
{
    public function getAll()
    {
        return UserMusicView::where([
            UserMusicViewConstant::USER_ID => Auth::user()['id']
        ])
            ->orderBy(UserMusicViewConstant::MUSIC_ID, 'asc')
            ->get()
            ->toArray();
    }

    public function getById(int $id): Music
    {
        return UserMusicView::where([
            UserMusicViewConstant::USER_ID => Auth::user()['id'],
            UserMusicViewConstant::MUSIC_ID => $id
        ])->first();
    }

    public function add(string $title, string $niconico_id, bool $favorite, bool $skip)
    {
        $model = new Music();

        $model[MusicConstant::TITLE] = $title;
        $model[MusicConstant::NICONICO_ID] = $niconico_id;

        $model->save();

        $music_id = $model[MusicConstant::ID];

        $model = new UserMusic();

        $model[UserMusicConstant::USER_ID] = Auth::user()['id'];
        $model[UserMusicConstant::MUSIC_ID] = $music_id;
        $model[UserMusicConstant::FAVORITE] = $favorite;
        $model[UserMusicConstant::SKIP] = $skip;

        $model->save();
    }

    public function update(int $music_id, string $title, string $niconico_id, bool $favorite, bool $skip)
    {
        $model = Music::where(MusicConstant::ID, $music_id)
            ->first();

        $model[MusicConstant::TITLE] = $title;
        $model[MusicConstant::NICONICO_ID] = $niconico_id;

        $model->save();

        $object = UserMusic::where([
            UserMusicConstant::USER_ID => Auth::user()['id'],
            UserMusicConstant::MUSIC_ID => $music_id
        ]);

        if ($object->exists()) {
            $model = $object->first();
        } else {
            $model = new UserMusic();
        }

        $model[UserMusicConstant::USER_ID] = Auth::user()['id'];
        $model[UserMusicConstant::MUSIC_ID] = $music_id;
        $model[UserMusicConstant::FAVORITE] = $favorite;
        $model[UserMusicConstant::SKIP] = $skip;

        $model->save();
    }

    public function delete(int $id)
    {
        Music::where(MusicConstant::ID, $id)
            ->delete();
    }
}
