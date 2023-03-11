<?php

namespace App\Services;

use App\Models\Music;
use App\Models\Constants\MusicConstant;

class MylistAssistantService
{
    public function getAll()
    {
        return Music::all()->toArray();
    }

    public function getById(int $id): Music
    {
        return Music::where(MusicConstant::ID, $id)
            ->first();
    }

    public function add(string $title, string $niconico_id)
    {
        $model = new Music();

        $model[MusicConstant::TITLE] = $title;
        $model[MusicConstant::NICONICO_ID] = $niconico_id;

        $model->save();
    }

    public function update(int $id, string $title, string $niconico_id)
    {
        $model = Music::where(MusicConstant::ID, $id)
            ->first();

        $model[MusicConstant::TITLE] = $title;
        $model[MusicConstant::NICONICO_ID] = $niconico_id;

        $model->save();
    }

    public function delete(int $id)
    {
        Music::where(MusicConstant::ID, $id)
            ->delete();
    }
}
