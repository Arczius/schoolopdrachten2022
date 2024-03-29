<?php

namespace App\Controllers;

use App\Models\Songs;
use App\Models\Genres;
use App\Models\GenresSongs;

class Home extends BaseController
{
    private $songsModel;
    private $genreModel;
    private $genresSongsModel;

    public function __construct()
    {
        helper("userLoginData");    
        helper("queueSongData");
        $this->songsModel = new Songs();
        $this->genreModel = new Genres();
        $this->genresSongsModel = new GenresSongs();
    }
    
    /**
     * index - home page for the app ( the page where you can see all the genre's etc )
     *
     * @return void
     */
    public function index()
    {

        $data = [
            'title' => "Home",
            'isLoggedIn' => userLoginData(),
        ];
        
        
        
        echo view('templates/head', $data);
        echo view('templates/header', $data);


        echo view('Home/index_base_start');


        $allGenres = $this->genreModel->findAll();

        foreach($allGenres as $genre){
            $data['category'] = $genre;
            echo view('Home/genre', $data);
        }


        echo view('Home/index_base_end');

        $queue = queueSongData();
        


        $data['queue'] = $queue;

        echo view('templates/queue', $data);
    }
    
    /**
     * singleCat - a detail page for a single category
     *
     * @param  string $catname the name of the genre
     * @return void
     */
    public function singleCat($catname){
        $genre = $this->genreModel->where('name', $catname)->find();

        if(count($genre) === 0){
            return redirect("/");
        }

        $genreSongs = $this->genresSongsModel->where('genre_id', $genre[0]['id'])->findAll();


        $data = [
            'title' => "songs of $catname",
            'isLoggedIn' => userLoginData(),
        ];

        echo view('templates/head', $data);
        echo view('templates/header', $data);


        echo view('Home/index_base_start');

        foreach($genreSongs as $genreSong){
            $song = $this->songsModel->where('id', $genreSong['song_id'])->find();
            $song = $song[0];
            $data['songName'] = $song['songName'];
            $data['artistName'] = $song['artistName'];
            $data['songId'] = $song['id'];
            $data['genreName'] = $catname;
            echo view('Home/song', $data);
        }

        echo view('Home/index_base_end');



        $queue = queueSongData();
        

        $data['queue'] = $queue;

        echo view('templates/queue', $data);
    }
}
