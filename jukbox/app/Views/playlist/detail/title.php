<?php 
helper("PlaylistTimer");
?>

<h1 class="text-5xl"><?php echo $title?></h1>
<h3 class="text-2xl">A Playlist By: <a class="text-indigo-800" href="<?php echo base_url() . "/user/" . $user?>"><?php echo $user ?></a></h3>

<h5 class="text-xl">totale lengte: <?php 


$playlistTimeManager = new PlaylistTimer();

echo $playlistTimeManager->getFromModel($playlistID);
?></h5>

<?php
    if($isLoggedIn !== null && $userID === $isLoggedIn['id']){
        echo form_open("/changeName/$playlistID");
        ?>

        <input class="border-double border-4 border-sky-500 rounded-lg p-2" type="text" name="name" value="<?php echo $title ?>">

        <input class="border-double border-4 border-sky-500 rounded-lg p-2" type="submit" value="verander naam">
        
        <?php
        echo form_close();

        ?>
            <a href="<?php echo base_url(); ?>/addSong/<?php echo $playlistID ?>">add a song</a>
        <?php
    }
?>

<h4 class="text-xl pt-6 pb-2">Songs:</h4>
