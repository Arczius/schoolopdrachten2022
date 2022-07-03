<?php
    include_once './functions/functions.php';


    $categories = getCategories();


    $lists = getItems();


    include_once './parts/head.php';

    if(isset($_GET['errorcategory'])){
        alert("kan geen cattegorie verwijderen waar nog items aan gekoppeld zijn");
    }
?>

<body>

    <main class="container">

        <?php
        foreach($categories as $category){
            ?>
            <div class="categoryItem">
                <div class="title">
                    <h1>
                        <?php echo $category['Name'];?>

                        <a href="./delete.php?id=<?php echo $category['id']; ?>&type=category"> <i class="fa-solid fa-trash-can"></i></a>
                    </h1>
                </div>
                
                <ul>
                    
                    <?php 
                    foreach($lists as $item){
                        if($item['category'] === $category['Name']){
                            ?>
                                <li>
                                    <div class="name">
                                        <?php echo $item['nameOrContent']; ?>
                                    </div>
                                    <div class="delete">
                                        <a href="./delete.php?id=<?php echo $item['id'];?>&type=item">

                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </li>
                                <?php
                        }
                    }
                    ?>

                </ul>
            </div>

        <?php
            }
        ?>
     
    </main>
    <?php
        include_once './parts/footer.php';
    ?>
</body>
</html>