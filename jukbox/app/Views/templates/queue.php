<?php
    if(isset($queue[0]) ){
        ?>
        <ul class="fixed right-8 bottom-12 bg-white">
            <?php            
            foreach($queue as $queueItem){
                ?>
                    <li>
                        <a href="<?php echo base_url()?>/removeQueue/<?php echo $queueItem['id'] ?>">
                            <i class="fa-solid fa-trash-can"></i> <?php echo $queueItem['songName'];?>
                        </a>
                    </li>

                <?php
            }
            ?>
            <li><a href="<?php echo base_url()?>/playlistGen">make playlist</a></li>
        </ul>
        <?php
    }
?>