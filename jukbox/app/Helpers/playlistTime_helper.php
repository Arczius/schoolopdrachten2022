<?php

use App\Models\PlaylistSongs;
use App\Models\Songs;

function playlistTime($playlistID){
    $playlistSongsModel = new PlaylistSongs();

    $playlistSongs = $playlistSongsModel->where("playlist_id", $playlistID)->findAll();

    if(count($playlistSongs) > 0 ){
        $songModel = new Songs();
        $songLengthArr = [];
        foreach($playlistSongs as $playlistSong){
            $song = $songModel->where('id', $playlistSong['song_id'])->first(); 
            $length = "";

            if(count(explode(":", $song['songLength'])) !== 3){
                $length = "00:" . $song['songLength'];
            }
            else{
                $length = $song['songLength'];
            }
            
            
            array_push($songLengthArr, $length);
        }

        $songLength = 0;
        foreach($songLengthArr as $songLengthItem){
            $temp = explode(":", $songLengthItem); 
            $songLength+= (int) $temp[0] * 3600; 
            $songLength+= (int) $temp[1] * 60;
            $songLength+= (int) $temp[2];

        }

        $formatedLength = sprintf('%02d:%02d:%02d', ($songLength / 3600),($songLength / 60 % 60), $songLength % 60);

        return $formatedLength;

    }

    else{
        return null;
    }
}