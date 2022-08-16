    <main>
        
        <ul class="grid gap-5 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 p-1">
            <?php 
            foreach($songs as $song){
                ?>

                <li class="p-2 border-double border-4 border-sky-500 rounded-xl">
                    <a href="./songDetail/<?php echo $song['id']; ?>">
                    <div class="title">
                        <h3 class="text-3xl font-medium">
                            <?php echo $song['songName']?>
                        </h3>
                    </div>
                    <div class="artist">
                        <div class="text-xl">
                            Artist: <?php echo $song['artistName']; ?>
                        </div>
                        <div class="text-xl">
                    <?php
                foreach($genresSongs as $genreSong){
                    if($genreSong['song_id'] === $song['id']){
                        foreach($genres as $genre){
                            if($genreSong['genre_id'] === $genre['id']){
                                echo "Genre: ". $genre['name'];
                            }
                            
                        }
                    }
                }?>
                            
                            </div>
                        </div>

                        </a>
                        <?php
                            if(isset($isLoggedIn['username'])){
                                ?>
                                <a class="text-4xl underline text-lime-600" href="./queue/<?php echo $song['id']; ?>">add to queue</a>
                                <?php
                            }
                        ?>
                    </li>
                    
                    <?php
                }
            
            ?>
        </ul>
    </main>
    
    
    </body>
</html>