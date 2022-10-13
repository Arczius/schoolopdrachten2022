<?php echo form_open("/addSong/$playlistID"); ?>
    <select name="song_id">
        <?php 
        foreach($songs as $song){
            ?>
            <option value="<?php echo $song['id'] ?>"><?php echo $song['songName']?></option>
            <?php
        }
        
        ?>
    </select>
    <input type="submit" value="toevoegen">

<?php echo form_close(); ?>