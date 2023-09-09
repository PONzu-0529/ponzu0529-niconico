<?php

namespace App\Objects\NicoMylistAutoGen;

use Illuminate\Http\Request;

class CreateCustomMylistRequestObject
{
    private ?string $email;
    private ?string $password;
    private ?string $mylist_title;
    private ?int $count;

    public function __construct(Request $request)
    {
        $this->email = $request->input('email');
        $this->password = $request->input('password');
        $this->mylist_title = $request->input('mylist_title');
        $this->count = $request->input('count');
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getMylistTitle(): ?string
    {
        return $this->mylist_title;
    }

    public function setMylistTitle(string $mylist_title): void
    {
        $this->mylist_title = $mylist_title;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }
}
