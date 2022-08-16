<?php

namespace App\Controllers;

use App\Models\Playlists;
use App\Models\Users;
use App\Models\PlaylistUsers;
use App\Models\PlaylistSongs;
use App\Models\Songs;

class Playlist extends BaseController
{
    public function __construct()
    {
        helper("userLoginData");    
        helper("queueSongData");
    }

    public function index()
    {
        $data = [
            'title' => "alle afspeellijsten",
            'isLoggedIn' => userLoginData(),
        ];

        echo view("templates/head", $data);
        echo view("templates/header", $data);


        $playlists = new Playlists();
        $users = new Users();
        $playlistUsers = new PlaylistUsers();

        $data['playlist'] = $playlists->findAll();
        $data['users'] = $users->findAll();
        $data['playlistUsers'] = $playlistUsers->findAll();

        echo view("playlist/index/all_index", $data);
    }

    public function detail($id)
    {
        $playlists = new Playlists();
        
        $users = new Users();

        $playlistUsers = new PlaylistUsers();

        $playlistSongs = new PlaylistSongs();

        $songs = new Songs();

        $playlist = $playlists->where('id', $id)->first();



        $data = [
            'title' => $playlist['playlist_title'],
            'isLoggedIn' => userLoginData()
        ];

        echo view("templates/head", $data);
        echo view("templates/header", $data);


        $playlistUser = $playlistUsers->where('playlist_id', $playlist['id'])->first();
        $user = $users->where('id', $playlistUser['usr_id'])->first();


        $data['user'] = $user['username'];

        
        echo view("playlist/detail/title", $data);       

        echo "<ul class='flex gap-7'>";

        $playlistSong = $playlistSongs->where('playlist_id', $playlist['id'])->findAll();

        foreach($playlistSong as $item){
            $song = $songs->where('id', $item['song_id'])->first();
            $data = [
                'id' => $song['id'],
                'songName' => $song['songName'],
                'artist' => $song['artistName'],
                'length' => $song['songLength'],
            ];
            echo view("playlist/detail/song", $data);
        }


        echo "</ul>";
    }
}