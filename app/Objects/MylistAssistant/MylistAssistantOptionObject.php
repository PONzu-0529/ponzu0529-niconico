<?php

namespace App\Objects\MylistAssistant;

class MylistAssistantOptionObject
{
    private int $count;

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }
}
