<body>
    <header>
        <a href="/">
            <h1 class="text-7xl underline">JukBox</h1>
        </a>
        <div class="flex gap-8">
            <a href="/playlists" class="text-3xl text-cyan-700">bekijk alle afspeellijsten</a>
            <?php
                if(isset($isLoggedIn['username'])){
                    ?>
                    <a href="/uitloggen" class="text-3xl text-cyan-700">uitloggen uit <?php echo $isLoggedIn['username'] ?></a>
                <?php
                }
                else{

                    ?>
                    <a href="/login" class="text-3xl text-cyan-700">inloggen</a>
                    <a href="/register" class="text-3xl text-cyan-700">registreren</a>
                    <?php
                }
            ?>
        </div>
    </header>
    