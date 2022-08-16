<?php
namespace App\Controllers;

use App\Models\Songs;
use App\Models\Genres;
use App\Models\GenresSongs;

class songDetail extends BaseController
{
    public function __construct()
    {
        helper("userLoginData");
    }

    public function index($id)
    {
        $songs = new Songs();
        $song = $songs->where('id', $id)->find();

        $genresSongs = new GenresSongs();
        $genresSong = $genresSongs->where('song_id', $song[0]['id'])->find();

        $genres = new Genres();
        $genre = $genres->where('id', $genresSong[0]['genre_id'])->find();


        $data =  [
            'title' => $song[0]['songName'] . ' by ' . $song[0]['artistName'],
            'isLoggedIn' => userLoginData(),
        ];

        echo view('templates/head', $data);
        echo view('templates/header');


        $data['song'] = $song[0];
        $data['genre'] = $genre[0];

        echo view('songDetail/index', $data);

    }
}
