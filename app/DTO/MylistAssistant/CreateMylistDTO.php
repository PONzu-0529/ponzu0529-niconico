<?php

namespace App\DTO\MylistAssistant;

/**
 * Create Mylist DTO
 */
class CreateMylistDTO
{
    private string $email;
    private string $password;
    private string $mylist_title;
    private array $music_id_list;

    public function __construct(string $email, string $password, string $mylist_title, array $music_id_list)
    {
        $this->email = $email;
        $this->password = $password;
        $this->mylist_title = $mylist_title;
        $this->music_id_list = $music_id_list;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getMylistTitle(): string
    {
        return $this->mylist_title;
    }

    public function setMylistTitle(string $mylist_title): void
    {
        $this->mylist_title = $mylist_title;
    }

    public function getMusicIdList(): array
    {
        return $this->music_id_list;
    }

    public function setMusicIdList(array $music_id_list): void
    {
        $this->music_id_list = $music_id_list;
    }
}
