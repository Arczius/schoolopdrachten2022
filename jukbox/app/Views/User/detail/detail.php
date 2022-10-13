<h1 class="text-7xl pt-5 text-center"><?php echo $username ?></h1>

<?php
    if(count($userPlaylists) > 0){
        ?>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 p-1">
            <?php
                foreach($userPlaylists as $playlist){
                    ?>
                    <div class="p-2 border-double border-4 border-sky-500 rounded-xl">
                        <a class="text-5xl" href="<?php echo base_url() . "/playlist/". $playlist['id']?>">
                            <?php echo $playlist['playlist_title'] ?> 
                        </a>
                    </div>


                    <?php
                }
            ?>
        </div>

        <?php
    }
    else{
        ?>
        <div class="pt-3">
            <h3 class="text-2xl text-center ">Sorry this user doesn't have any playlists</h3>
        </div>

        <?php
    }
?>