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
                if($list_item['name' === $loc_item['Name']]){
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