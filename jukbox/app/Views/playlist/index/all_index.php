<ul class="grid justify-center gap-5">
    <?php
        foreach($playlist as $plItem){
            ?>
                <li>
                    <a href="<?php echo base_url() ?>/playlist/<?php echo $plItem['id'];?>">

                        <h3><?php echo $plItem['playlist_title']; ?></h3>
                        
                        <?php
                        foreach($playlistUsers as $plUser){
                            if($plUser['playlist_id'] === $plItem['id']){
                                foreach($users as $user){
                                    if($user['id'] === $plUser['usr_id']){
                                        ?>

<div>
    a playlist by: <a href="<?php echo base_url()."/user/". $user['username']; ?>"><?php echo $user['username']; ?></a>
</div>

<?php
    if(isset($isLoggedIn['id']) && $user['id'] === $isLoggedIn['id']){
        ?>
        <a href="<?php echo base_url(). '/playlists/delete/'. $plItem['id']; ?>">
            delete
        </a>
        <?php
    }
?>

<?php
                                    }
                                }
                            }
                        }
                        ?>
                    </a>
                </li>

            <?php
        }

    ?>
</ul>