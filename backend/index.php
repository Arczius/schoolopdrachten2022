<?php
    include_once './functions/functions.php';

    $categories = getCategories();
    $lists;

    if(isset($_GET['ascending'])){
        $lists = getItemsAsc();
    }
    elseif(isset($_GET['desending'])){
        $lists = getItemsDesc();
    }
    else{
        $lists = getItems();
    }


    include_once './parts/head.php';
    if(isset($_GET['errorcategory'])){
        alert("cant delete cattegory since sub list items exist");
    }

?>

<body>
    <header class="container pb-5">
        <a href="./index.php" class="pr-6">no sorting</a>
        <a href="./index.php?ascending" class="pr-6">ascending</a>
        <a href="./index.php?desending">desending</a>
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
                                    <li>
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