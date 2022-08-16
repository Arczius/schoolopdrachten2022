<?php
    if(isset($queue[0]) ){
        ?>
        <ul class="fixed right-8 bottom-12 bg-white">
            <?php            
            foreach($queue as $queueItem){
                ?>
                    <li>
                        <a href="/removeQueue/<?php echo $queueItem['id'] ?>">
                            <i class="fa-solid fa-trash-can"></i> <?php echo $queueItem['songName'];?>
                        </a>
                    </li>

                <?php
            }
            ?>
            <li><a href="/playlistGen">make playlist</a></li>
        </ul>
        <?php
    }
?>