<?php

namespace App\Controllers;

use App\Models\Songs;
use App\Models\Genres;
use App\Models\GenresSongs;

class Home extends BaseController
{
    public function __construct()
    {
        helper("userLoginData");    
        helper("queueSongData");
    }

    public function index()
    {

        $data = [
            'title' => "Home",
            'isLoggedIn' => userLoginData(),
        ];
        
        
        
        echo view('templates/head', $data);
        echo view('templates/header', $data);


        $songs = new Songs();
        $genre = new Genres();
        $genresSongs = new GenresSongs();

        $all_songs = $songs->findAll();


        echo view('Home/index_base_start');

        foreach($all_songs as $song){
            $genre_song = $genresSongs->where('song_id', $song['id'])->find();
            $songGenre = $genre->where('id', $genre_song[0]['genre_id'])->find();


            $data['songName'] = $song['songName'];
            $data['artistName'] = $song['artistName'];
            $data['songId'] = $song['id'];
            $data['genreName'] = $songGenre[0]['name'];

            echo view('Home/song', $data);
        }


        echo view('Home/index_base_end');

        $queue = queueSongData();
        


        $data['queue'] = $queue;

        echo view('templates/queue', $data);
    }
}
