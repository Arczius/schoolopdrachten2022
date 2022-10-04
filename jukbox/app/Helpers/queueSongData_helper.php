<?php

use App\Models\Songs;

function queueSongData(){
    // initializing array
    $items = [];


    $songs = new Songs();

    $sessionSongId = session()->get('queue');

    if(isset($sessionSongId) && count($sessionSongId) > 0){
        foreach($sessionSongId as $song){
            $songItem = $songs->where('id', $song)->find();
            array_push($items, $songItem[0]);
        }
    }

    return $items;
}