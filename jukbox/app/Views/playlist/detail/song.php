<li>
    <a href="<?php echo base_url()?>/songDetail/<?php echo $id ?>">

        <h3><?php echo $songName?></h3>
        <ul>
            <li>Artiest: <?php echo $artist ?></li>
            <li>Lengte: <?php echo $length?></li>
        </ul>
        <?php
        if(isset($isLoggedIn) && $isLoggedIn['id'] === $userID){
            ?>

            <a class="block" href="<?php echo base_url()?>/playlist/deleteSong/<?php echo $playlistID ?>/<?php echo $id ?>">
                delete
            </a>
            <?php if(!$hideMoveButtons){
                ?>

            <a class="block" href="<?php echo base_url() ?>/playlist/moveSongUp/<?php echo $playlistID . "/" . $id ?>">
                move up
            </a>
            <a class="block" href="<?php echo base_url() ?>/playlist/moveSongDown/<?php echo $playlistID . "/" . $id ?>">
                move down
            </a>
            <?php
            } ?>
            <?php
        } 
        ?>
    </a>
</li>