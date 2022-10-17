<?php
    include_once './config/config.php';



    // using javascript alert's in your php code
    function alert($message){
        echo "<script type='text/javascript'>
            alert('$message'); 
        </script>";
    }

    // a function to redirect you to a different page using a php header
    function redirectPage($location){
        header('location: ' . $location);
        exit;
    }
    
    // a function to get all the categories from the database
    function getCategories(){
        $query = "SELECT * FROM categories";    
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();

        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    // a function to get all the items from the database
    function getItems(){
        $query = "SELECT * FROM lists";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();
        
        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    // a function to get all the items from the database in an ascending order
    function getItemsAsc(){
        $query = "SELECT * FROM lists ORDER BY length ASC";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();
        
        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    // a function to get all the items from the database in an descending order
    function getItemsDesc(){
        $query = "SELECT * FROM lists ORDER BY length DESC";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();
        
        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    // a function to get a single item from the database
    function getSingleItem($id){
        $query = "SELECT * FROM lists WHERE id = :id";
        $item = $GLOBALS['db']->prepare($query);
        $item->bindParam('id', $id, PDO::PARAM_INT);
        $item->execute();

        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    // a function to get a single category from the database
    function getSingleCategory($id){
        $query = "SELECT * FROM categories WHERE id = :id";
        $item = $GLOBALS['db']->prepare($query);
        $item->bindParam('id', $id, PDO::PARAM_INT);
        $item->execute();

        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    // a function to delete a single item from the database
    function deleteItem($id){
        $query = "DELETE FROM lists WHERE id=:id LIMIT 1";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->bindParam('id', $id, PDO::PARAM_INT);
        $conn->execute();

        redirectPage("./index.php");
    }

    // a function to delete a single category from the database
    function deleteCategory($id){
        $query = "SELECT * FROM categories WHERE id=$id LIMIT 1";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();
        $item = $item->fetchAll(\PDO::FETCH_ASSOC);


        $query = "SELECT * FROM lists";
        $list_items = $GLOBALS['db']->prepare($query);
        $list_items->execute();
        $list_items = $list_items->fetchAll(\PDO::FETCH_ASSOC);

        $exists = false;

        foreach($item as $loc_item){
            foreach($list_items as $list_item){
                if($list_item['category'] === $loc_item['id']){
                    $exists = true;
                }
            }
        }

        if(!$exists){
            $query = "DELETE FROM categories WHERE id=:id LIMIT 1";
            $conn = $GLOBALS['db']->prepare($query);
            $conn->bindParam('id', $id, PDO::PARAM_INT);
            $conn->execute();

            redirectPage("./index.php");
        }
        else{
            redirectPage("./index.php?errorcategory");
        }
    }


    // a function to make a new category in the database
    function newCategory($name){
        $query = "INSERT INTO categories (Name) VALUES(':name')";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->bindParam('name', $name, PDO::PARAM_STR);
        $conn->execute();

        redirectPage("./index.php");
    }


    // a function to make a new item in the database
    function newItem($content, $length, $catId){
        $query = "SELECT * FROM categories WHERE id=$catId LIMIT 1";
        $category = $GLOBALS['db']->query($query);
        foreach($category as $cat){
            $c_id = $cat['id'];
            $query = "INSERT INTO lists (category,nameOrContent,length) VALUES ( :cat_id, ':content', :length )";
            $conn = $GLOBALS['db']->prepare($query);
            $conn->bindParam('cat_id', $c_id, PDO::PARAM_INT);
            $conn->bindParam('content', $content, PDO::PARAM_STR);
            $conn->bindParam('length', $length, PDO::PARAM_INT);
            $conn->execute();
        }
        redirectPage("./index.php");
    }


    // a function to update a category in the database
    function updateCategory($id, $name){
        $query = "UPDATE categories SET Name='$name' WHERE id=$id";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->execute();
        
        redirectPage("./index.php");
    }

    
    // a function to update a item in the database
    function updateItem($id, $name, $length, $status){
        $query = "UPDATE lists SET nameOrContent=':name', length=:length, status=':status' WHERE id=:id";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->bindParam('length', $length, PDO::PARAM_INT);
        $conn->bindParam('name', $name, PDO::PARAM_STR);
        $conn->bindParam('status', $status, PDO::PARAM_STR);
        $conn->bindParam('id', $id, PDO::PARAM_INT);
        $conn->execute();
        
        redirectPage("./index.php");
    }


    // a function to get a parsed url so you can see all the information about the url
    function getParsedUrl(){
        return parse_url("http://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI']);
    }

    // a function to get all items in an ascending order, with a specific status, from the database
    function getItemsAscHasStatus($status){
        switch($status){
            case 'completed':
            case 'working':
            case 'open':
                $query = "SELECT * FROM lists WHERE status = '$status' ORDER BY length ASC";
                $item = $GLOBALS['db']->prepare($query);
                $item->execute(); 
                return $item->fetchAll(\PDO::FETCH_ASSOC);
            break;

            default:
                redirectPage("./index.php");
        }
    }

    // a function to get all items in an descending order, with a specific status, from the database
    function getItemsDescHasStatus($status){
        switch($status){
            case 'completed':
            case 'working':
            case 'open':
                $query = "SELECT * FROM lists WHERE status = '$status' ORDER BY length DESC";
                $item = $GLOBALS['db']->prepare($query);
                $item->execute(); 
                return $item->fetchAll(\PDO::FETCH_ASSOC);
            break;

            default:
                redirectPage("./index.php");
        }
    }

    // a function to get all items  with a specific status from the database
    function getItemsHasStatus($status){ 
        switch($status){
            case 'completed':
            case 'working':
            case 'open':
                $query = "SELECT * FROM lists WHERE status = '$status'";
                $item = $GLOBALS['db']->prepare($query);
                $item->execute(); 
                return $item->fetchAll(\PDO::FETCH_ASSOC);
            break;

            default:
                redirectPage("./index.php");
        }
    }