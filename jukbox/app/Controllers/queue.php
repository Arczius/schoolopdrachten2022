<?php

namespace App\Controllers;

use App\Models\Playlists;
use App\Models\PlaylistSongs;
use App\Models\PlaylistUsers;

class queue extends BaseController
{
    public function __construct()
    {
        helper("userLoginData");
    }

    public function index($id)
    {
        $user = userLoginData();
        if(isset($user['username'])){
            if(isset($id) && is_numeric($id)){
                if(isset(session()->get("queue")[0])){
                    if(!in_array($id, session()->get("queue"))){
                        session()->push("queue", [$id]);
                    } 
                }
                else{ 
                    session()->set("queue", [$id]);
                }
            }
        }
            
        return redirect("/");
    }
    public function removeQueue($id)
    {
        $queue = session()->get("queue");
        foreach($queue as $position=>$item){
            if($item == $id){
                unset($queue[$position]);
            }
        }
        session()->set("queue", $queue);
        return redirect()->back();
    }

    public function makePlaylist(){

        $post = $this->request->getPost();


        $user = userLoginData();
        if(isset($user['id'])){
            if(isset($post['playlist_title'])){

                $playlists = new Playlists();
                $playlist_users = new PlaylistUsers();
                $playlist_songs = new PlaylistSongs();


                $playlists->insert($post);

                $last_playlist = $playlists->where('playlist_title', $post['playlist_title'])->orderBy('id', 'desc')->first();

                
                //setting the user for the playlist
                $playlist_users_data['playlist_id'] = $last_playlist['id'];
                $playlist_users_data['usr_id'] = $user['id'];
                $playlist_users->insert($playlist_users_data);


                $queue = session()->get("queue");

                var_dump($queue);

                foreach($queue as $queueItem){
                    $song_data['song_id'] = $queueItem;
                    $song_data['playlist_id'] = $last_playlist['id'];
                    $playlist_songs->insert($song_data);
                }

                session()->remove("queue");

                return redirect("/");
            }
            else{
                $data['title'] = "maak een playlist aan";
                echo view("templates/head", $data);
                echo view("queue/playlistTitle");
            }
        }
        else{
            return redirect()->back();
        }

    }
}