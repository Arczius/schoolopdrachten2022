<?php
    include_once './config/config.php';



    function alert($message){
        echo "<script type='text/javascript'>
            alert('$message'); 
        </script>";
    }

    function redirectPage($location){
        header('location: ' . $location);
        exit;
    }
    

    function getCategories(){
        $query = "SELECT * FROM categories";    
        $item = $GLOBALS['db']->query($query);

        return $item;
    }

    function getItems(){
        $query = "SELECT * FROM lists";
        $item = $GLOBALS['db']->query($query);
        
        return $item;
    }

    function deleteItem($id){
        $query = "DELETE FROM lists WHERE id=$id LIMIT 1";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->execute();
    }

    function deleteCategory($id){
        $query = "SELECT * FROM categories WHERE id=$id LIMIT 1";
        $item = $GLOBALS['db']->query($query);

        $query = "SELECT * FROM lists";
        $list_items = $GLOBALS['db']->query($query);

        $exists = false;

        foreach($item as $loc_item){
            foreach($list_items as $list_item){
                if($list_item['category'] === $loc_item['Name']){
                    $exists = true;
                }
            }
        }

        if(!$exists){
            $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
            $conn = $GLOBALS['db']->prepare($query);
            $conn->execute();

            redirectPage("./index.php");
        }
        else{
            redirectPage("./index.php?errorcategory");
        }
    }


    function newCategory($name){
        $query = "INSERT INTO categories (Name) VALUES('$name')";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->execute();

        redirectPage("./index.php");
    }


    function newItem($content, $catId){
        $query = "SELECT * FROM categories WHERE id=$catId LIMIT 1";
        $category = $GLOBALS['db']->query($query);
        foreach($category as $cat){
            $c_name = $cat['Name'];
            $query = "INSERT INTO lists (category,nameOrContent) VALUES ('$c_name', '$content')";
            $conn = $GLOBALS['db']->prepare($query);
            $conn->execute();
        }
        redirectPage("./index.php");
    }