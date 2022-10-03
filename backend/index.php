<?php
    include_once './functions/functions.php';

    $categories = getCategories();
    $url = getParsedUrl();
    $lists;

    if(isset($_GET['ascending'])){
        if(isset($_GET['status'])){
            $lists = getItemsAscHasStatus($_GET['status']);
        }
        else{
            $lists = getItemsAsc();
        }
        
    }
    elseif(isset($_GET['desending'])){
        if(isset($_GET['status'])){
            $lists = getItemsDescHasStatus($_GET['status']);
        }
        else{
            $lists = getItemsDesc();
        }
    }
    else{
        if(isset($_GET['status'])){
            $lists = getItemsHasStatus($_GET['status']);
        }
        else{
            $lists = getItems();
        }
    }


    include_once './parts/head.php';
    if(isset($_GET['errorcategory'])){
        alert("cant delete cattegory since sub list items exist");
    }

?>

<body>
    <header class="container pb-5">
        <a href="./index.php" class="pr-6">no sorting</a>
        <div class="pb-5">
            <h2 class="title pb-0 mb-0">Sorting ascending/desending</h2>
            <div>
                <?php 
                if(isset($_GET['status'])){
                    ?>
                    <a href="./index.php?ascending&status=<?php echo $_GET['status'];?>" class="pr-6">ascending</a>
                    
                    <a href="./index.php?desending&status=<?php echo $_GET['status'];?>">desending</a>
                    <?php
                }

                else{
                    ?>
                    <a href="./index.php?ascending" class="pr-6">ascending</a>
                    <a href="./index.php?desending">desending</a>
                    <?php
                }
                
                ?>
            </div>

        </div>
        <div class="pb-5">
            <h2 class="title pb-0 mb-0">Sorting status</h2>
            <div>
                <?php
                    if(isset($_GET['ascending'])){
                    ?>
                    <a href="./index.php?ascending&status=completed" class="pr-6">completed</a>
                    <a href="./index.php?ascending&status=working" class="pr-6">working</a>
                    <a href="./index.php?ascending&status=open">open</a>
                    <?php
                    }
                    elseif(isset($_GET['desending'])){
                        ?>

                        <a href="./index.php?desending&status=completed" class="pr-6">completed</a>
                        <a href="./index.php?desending&status=working" class="pr-6">working</a>
                        <a href="./index.php?desending&status=open">open</a>
                        <?php
                    }
                    else{
                        ?>
                        <a href="./index.php?status=completed" class="pr-6">completed</a>
                        <a href="./index.php?status=working" class="pr-6">working</a>
                        <a href="./index.php?status=open">open</a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </header>
    <main class="container">

        <div class="columns is-multiline">

            <?php
            foreach($categories as $category){
                ?>  
                <div class="column is-one-third">
                    <div class="title">
                        <h1>
                            <?php echo $category['Name'];?>

                            <a href="./edit.php?type=category&id=<?php echo $category['id']; ?>"><i class="fa-solid fa-pencil"></i></a>
                            <a href="./delete.php?id=<?php echo $category['id']; ?>&type=category"> <i class="fa-solid fa-trash-can"></i></a>
                        </h1>
                    </div>

                    <ul>

                        <?php
                        foreach ($lists as $item) {
                            if($item['category'] == $category['id']){
                                ?>
                                    <li class="pb-2">
                                        <span class="name">
                                            <?php echo $item['nameOrContent']; ?>:
                                            <?php echo $item['length'];?> Lengte
                                        </span>
                                        <span class="edit">
                                            <a href="./edit.php?type=item&id=<?php echo $item['id']; ?>">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        </span>
                                        <span>
                                            <a href="./delete.php?id=<?php echo $item['id'];?>&type=item">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </span>
                                        <br>
                                        <?php

                                        // een check of de status wel bestaat, in oude versie bestond deze niet dus dit is voor de oude items nodig
                                        if(isset($item['status']) && $item['status'] !== null && $item['status'] !== ""){
                                            ?>
                                            <span>
                                            status: <?php echo $item['status']; ?>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <?php
                            }
                        }
                        ?>

                    </ul>

                    <div>
                        <a href="./new.php?type=item&catId=<?php echo $category['id']; ?>">nieuw item</a>
                    </div>
                </div>

            <?php
                }
            ?>
            <div class="column is-one-third">
                <a href="./new.php?type=category">nieuwe category</a>
            </div>
     
        </div>
    </main>
    <?php
        include_once './parts/footer.php';
    ?>
</body>
</html>