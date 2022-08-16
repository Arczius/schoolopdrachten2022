<?php
use App\Models\Users;
function userLoginData()
{
    $users = new Users();

    return $users->where("id", session()->get("id"))->first();
}