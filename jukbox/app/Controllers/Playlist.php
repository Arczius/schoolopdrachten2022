<?php

namespace App\Controllers;

use App\Models\Playlists;
use App\Models\Users;
use App\Models\PlaylistUsers;
use App\Models\PlaylistSongs;
use App\Models\Songs;
use CodeIgniter\Database\RawSql;

class Playlist extends BaseController
{
    public function __construct()
    {
        helper("userLoginData");    
        helper("queueSongData");
    }
    
    /**
     * index - the all playlist page
     *
     * @return void
     */
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
    
    /**
     * deletePlaylist - a method for deleting a playlist
     *
     * @param  int|string $id the id of the playlist you want to delete
     * @return void
     */
    public function deletePlaylist($id){
        $playlistUsersModel = new PlaylistUsers();
        $playlistSongModel = new PlaylistSongs();
        $playlistsModel = new Playlists();
 
        $user = userLoginData();

        $playlistUser = $playlistUsersModel->where('playlist_id', $id)->first();

        if($user['id'] === $playlistUser['usr_id']){
            $playlistsModel->where('id', $id)->delete();
            $playlistUsersModel->where('playlist_id', $id)->delete();
            $playlistSongModel->where('playlist_id', $id)->delete();
        }
        return redirect()->to("/playlists");
    }

    
    /**
     * detail - the playlist detail pages
     *
     * @param  int|string $id the id of the playlist you want to select
     * @return void
     */
    public function detail($id)
    {
        helper("playlistTime");

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
        $data['userID'] = $user['id'];
        $data['playlistID'] = $id;

        
        echo view("playlist/detail/title", $data);       

        echo "<ul class='flex gap-7'>";

        $playlistSong = $playlistSongs->where('playlist_id', $playlist['id'])->orderBy("playlist_order", 'ASC')->findAll();

        foreach($playlistSong as $item){
            $song = $songs->where('id', $item['song_id'])->first();

            $data = [
                'id' => $song['id'],
                'songName' => $song['songName'],
                'artist' => $song['artistName'],
                'length' => $song['songLength'],
            ];
            // var_dump($item);
            if($item['playlist_order'] === "1" || $item['playlist_order'] === strval(count($playlistSong))){
                $data['hideMoveButtons'] = true;
            }
            else{
                $data['hideMoveButtons'] = false;
            }
            echo view("playlist/detail/song", $data);
        }


        echo "</ul>";
    }


    
    /**
     * deleteSong - a method to delete a song from the playlist
     *
     * @param  int|string $playlistID the id of the playlist you want to delete the song from
     * @param  int|string $songID the id of the song you want to remove from the playlist
     * @return void
     */
    public function deleteSong($playlistID, $songID){
        $user = userLoginData();

        $playlistUserModel = new PlaylistUsers;

        $playlistUserCheck = $playlistUserModel->where('playlist_id', $playlistID)->first();

        $playlistSongModel = new PlaylistSongs();

        if($user['id'] === $playlistUserCheck['usr_id']){
            $playlistSongModel->where('song_id', $songID)->delete();


            $songs = $playlistSongModel->where('playlist_id', $playlistID)->orderBy('playlist_order', 'ASC')->findAll();

            if(count($songs) > 0 && count($songs) < $songs[count($songs) - 1]['playlist_order']){
                for($i = 1;  $i <= count($songs); $i++){
                    $item = $i -1;
                    $data = [
                        'id' => $songs[$item]['id'],
                        'playlist_id' => $songs[$item]['playlist_id'],
                        'song_id' => $songs[$item]['song_id'], 
                        'playlist_order' => $i,
                    ];
                    $playlistSongModel->replace($data);
                }
            }
        }

        return redirect()->to("/playlist/$playlistID");
    }
    
    /**
     * orderUp - a method to make the order of an item go up in the playlist
     *
     * @param  int|string $playlistID the id of the playlist which song you wanna move up in the order
     * @param  int|string $songID the id of the song you want order the id up
     * @return void
     */
    public function orderUp($playlistID, $songID){

        $playlistSongModel = new PlaylistSongs();        

        $user = userLoginData();

        // $where = "song_id={$songID} AND playlist_id={$playlistID}";
        $song = $playlistSongModel->where("song_id", $songID)->where("playlist_id", $playlistID)->first();

        if($song !== null){
            $playlistUserModel = new PlaylistUsers();

            $playlistUser = $playlistUserModel->where('playlist_id', $song['playlist_id'])->first();

            if($user['id'] === $playlistUser['usr_id']){
                $order_val = intval($song['playlist_order']) - 1 ;
                $data = [
                    'id' => $song['id'],
                    'playlist_id' => $song['playlist_id'],
                    'song_id' => $song['song_id'],
                    'playlist_order' => $order_val,
                ];

                $song_id = $song['song_id'];

                $playlistSongModel->replace($data);

                // $where = "playlist_id={$playlistID} AND playlist_order={$order_val} AND NOT song_id={$song_id}";
                $lastItem = $playlistSongModel->where("playlist_id",$playlistID)->where('playlist_order', $order_val)->where('song_id !=', $song_id)->first();

                $lastOrderVal = intval($lastItem['playlist_order']) + 1;
                $data = [
                    'id' => $lastItem['id'],
                    'playlist_id' => $lastItem['playlist_id'],
                    'song_id' => $lastItem['song_id'],
                    'playlist_order' => $lastOrderVal,
                ];
                $playlistSongModel->replace($data);
            }
        }

        return redirect()->to("/playlist/$playlistID");
    }

    
    /**
     * orderDown - a method to make the order of an item go down in the playlist
     *
     * @param  int|string $playlistID the id of the playlist which song you wanna move down in the order
     * @param  int|string $songID the id of the song you want order the id down
     * @return void
     */
    public function orderDown($playlistID, $songID){
        $playlistSongModel = new PlaylistSongs();        

        $user = userLoginData();

        $where = "song_id={$songID} AND playlist_id={$playlistID}";
        $song = $playlistSongModel->where($where)->first();

        if($song !== null){
            $playlistUserModel = new PlaylistUsers();

            $playlistUser = $playlistUserModel->where('playlist_id', $song['playlist_id'])->first();

            if($user['id'] === $playlistUser['usr_id']){
                $order_val = intval($song['playlist_order']) + 1;
                $data = [
                    'id' => $song['id'],
                    'playlist_id' => $song['playlist_id'],
                    'song_id' => $song['song_id'],
                    'playlist_order' => $order_val,
                ];

                $song_id = $song['song_id'];

                $playlistSongModel->replace($data);

                $where = "playlist_id={$playlistID} AND playlist_order={$order_val} AND NOT song_id={$song_id}";
                $lastItem = $playlistSongModel->where(new rawSql($where))->first();

                $lastOrderVal = intval($lastItem['playlist_order']) - 1;
                $data = [
                    'id' => $lastItem['id'],
                    'playlist_id' => $lastItem['playlist_id'],
                    'song_id' => $lastItem['song_id'],
                    'playlist_order' => $lastOrderVal,
                ];
                $playlistSongModel->replace($data);
            }
        }

        return redirect()->to("/playlist/$playlistID");

    }
    
    /**
     * changePlaylistName
     *
     * @param  mixed $playlistID
     * @return void
     */
    public function changePlaylistName($playlistID){
        $user = userLoginData();

        $playlistUserModel = new PlaylistUsers();

        $playlistUser = $playlistUserModel->where('playlist_id', $playlistID)->first();

        $post = $this->request->getPost();
        
        
        if(intval($user['id']) === intval($playlistUser['usr_id'])){
            
            echo $post['name'];

            $playlistModel = new Playlists();

            $data = [
                'id' => $playlistID,
                'playlist_title' => $post['name'],
            ];

            $playlistModel->replace($data);
        }

        return redirect()->to("/playlist/$playlistID");
    }
    
    /**
     * addSong - a method to add a song to a certain playlist
     *
     * @param  int|string $playlistID the id of the playlist where you wanna add the song to
     * @return void
     */
    public function addSong($playlistID){
        $playlistUsersModel = new PlaylistUsers();

        $playlistUser = $playlistUsersModel->where('playlist_id', $playlistID)->first();
        $user = userLoginData();
        if(isset($user) && $user['id'] === $playlistUser['usr_id']){
            $song_id = $this->request->getPost('song_id');

            $playlistSongModel = new PlaylistSongs();

            if(isset($song_id)){
                $playlistSongs = $playlistSongModel->where("playlist_id",$playlistID)->findAll();
                $order = count($playlistSongs) + 1;

                $data = [
                    'playlist_id' => $playlistID,
                    'song_id' => $song_id,
                    'playlist_order' => $order,
                ];
                $playlistSongModel->insert($data);

                return redirect()->to("/playlist/$playlistID");
            }


            else{
                $songsModel = new Songs(); 

                $data = [
                    'title' => 'add a song',
                    'isLoggedIn' => $user,
                    'playlistID' => $playlistID,
                ];
                echo view("templates/head", $data);
                echo view("templates/header", $data);

                $songs = [];
                $playlistSongs = $playlistSongModel->where('playlist_id', $playlistID)->findAll();
                $allSongs = $songsModel->findAll();

                foreach($allSongs as $song){
                    $inArray = false;
                    foreach($playlistSongs as $pl_song){
                        if($song['id'] === $pl_song['song_id']){
                            $inArray = true;
                        }
                    }

                    if(!$inArray){
                        array_push($songs, $song);
                    }
                }

                $data['songs'] = $songs;

                echo view("playlist/addSong/addSong", $data);
            }
        }
        else{
            return redirect()->to("/playlist/$playlistID");
        }
    }
}