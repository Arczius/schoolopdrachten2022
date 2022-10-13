<?php
namespace App\Controllers;

use App\Models\Playlists;
use App\Models\PlaylistUsers;
use CodeIgniter\Controller;
use App\Models\Users;

class User extends BaseController
{
    public function __construct()
    {
        helper("userLoginData");
    }

    public function index(){

    }

    public function detail($username){
        $userModel = new Users();

        $user = $userModel->where('username', $username)->first();

        if($user !== null){

            $playlistUserModel = new PlaylistUsers();

            $playlistsByThisUser = $playlistUserModel->where('usr_id', $user['id'])->findAll();
            $playlistModel = new Playlists();

            $playlistData = [];

            foreach($playlistsByThisUser as $playlistUser){
                $item = $playlistModel->where('id', $playlistUser['playlist_id'])->first();
                array_push($playlistData, $item);
            }


            $data = [
                'isLoggedIn' => userLoginData(),
                'title' => $user['username']. "'s pagina",
                'username' => $user['username'],
                'userPlaylists' => $playlistData,
            ];
            echo view("templates/head", $data);
            echo view("templates/header", $data);

            echo view("User/detail/detail", $data);

        }
        else{
            return redirect()->to("/");
        }
    }
}