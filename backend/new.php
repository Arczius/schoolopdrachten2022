<?php
    include_once './functions/functions.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_GET['createCat'])){
            $cat_name = $_POST['category_name'];
            echo $cat_name;
            newCategory($cat_name);
        }
        elseif(isset($_GET['createItem'])){
            if(isset($_GET['catId'])){

                $catid = $_GET['catId'];
                $content = $_POST['item_name'];
                
                newItem($content, $catid);
            }
        }
    }



    function createNewCatForm(){
        ?>
            <h1>new category</h1>
            <form action="./new.php?createCat=true" method="post">
                <input type="text" name="category_name" id="" placeholder="category name">
                <input type="submit" value="submit">
            </form>
        <?php
    }

    function createNewItemForm($catId){
        ?>
            <h1>new item</h1>
            <form action="./new.php?createItem=true&catId=<?php echo $catId; ?>" method="post">
                <input type="text" name="item_name" placeholder="item name/content">
                <input type="submit" value="submit">
            </form>
        <?php
    }
    

    if(isset($_GET['type'])){
        $type = $_GET['type'];

        include_once './parts/head.php';
        ?>
        <body>
            <a href="./index.php"><button>back</button></a>
            
        <?php

        switch($type):

            case 'category':
                createNewCatForm();
                break;


            case 'item':
                if(isset($_GET['catId'])){
                    createNewItemForm($_GET['catId']);
                }

                break;
            
            default: 
                //redirectPage("./index.php");
            
            
        endswitch;


        include_once './parts/footer.php';
            ?>

        </body>
        </html>
        <?php
    }
    else{
        //redirectPage("./index.php");
    }
