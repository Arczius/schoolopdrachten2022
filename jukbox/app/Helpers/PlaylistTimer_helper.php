<?php

use App\Models\PlaylistSongs;
use App\Models\Songs;

class PlaylistTimer
{
    private $SongsModel;
    private $PlaylistSongsModel;

    public function __construct()
    {
        $this->SongsModel = new Songs(); 
        $this->PlaylistSongsModel = new PlaylistSongs();
    }

    public function getFromInputOfSongIDs($songArr){
        $songLengthArr = [];
        foreach($songArr as $song){
            if(count(explode(":", $song['songLength'])) < 3){
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
        $songLength = (int) $songLength;


        $formatedLength = sprintf('%02d:%02d:%02d', ($songLength / 3600),($songLength / 60 % 60), $songLength % 60);

        return $formatedLength;
    }


    public function getFromModel($playlistID){

        $playlistSongs = $this->PlaylistSongsModel->where("playlist_id", $playlistID)->findAll();

        if(count($playlistSongs) > 0 ){
            $songLengthArr = [];
            foreach($playlistSongs as $playlistSong){
                $song = $this->SongsModel->where('id', $playlistSong['song_id'])->first(); 
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
            $songLength = (int) $songLength;

            $formatedLength = sprintf('%02d:%02d:%02d', ($songLength / 3600),($songLength / 60 % 60), $songLength % 60);

            return $formatedLength;
        }

        else{
            return null;
        }
    }
}