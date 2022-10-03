<li class="p-2 border-double border-4 border-sky-500 rounded-xl">
    <a href="<?php echo base_url() ?>/songDetail/<?php echo $songId; ?>">

        <div class="title">
            <h3 class="text-3xl font-medium">
                <?php echo $songName; ?>
            </h3>
        </div>

        <div class="artist">

            <div class="text-xl">
                Artist: <?php echo $artistName; ?>
            </div>

            <div class="text-xl">
                Genre: <?php echo $genreName; ?>
            </div>

        </div>

    </a>
    
    <?php
        if(isset($isLoggedIn['username'])){
            ?>
            <a class="text-4xl underline text-lime-600" href="<?php echo base_url()?>/queue/<?php echo $songId; ?>">add to queue</a>
            <?php
        }
    ?>

</li>