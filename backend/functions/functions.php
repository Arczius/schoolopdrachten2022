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
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();

        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getItems(){
        $query = "SELECT * FROM lists";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();
        
        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getItemsAsc(){
        $query = "SELECT * FROM lists ORDER BY length ASC";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();
        
        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getItemsDesc(){
        $query = "SELECT * FROM lists ORDER BY length DESC";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();
        
        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getSingleItem($id){
        $query = "SELECT * FROM lists WHERE id = $id";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();

        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getSingleCategory($id){
        $query = "SELECT * FROM categories WHERE id = $id";
        $item = $GLOBALS['db']->prepare($query);
        $item->execute();

        return $item->fetchAll(\PDO::FETCH_ASSOC);
    }

    function deleteItem($id){
        $query = "DELETE FROM lists WHERE id=$id LIMIT 1";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->execute();

        redirectPage("./index.php");
    }

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


    function newItem($content, $length, $catId){
        $query = "SELECT * FROM categories WHERE id=$catId LIMIT 1";
        $category = $GLOBALS['db']->query($query);
        foreach($category as $cat){
            $c_id = $cat['id'];
            $query = "INSERT INTO lists (category,nameOrContent,length) VALUES ('$c_id', '$content', $length)";
            $conn = $GLOBALS['db']->prepare($query);
            $conn->execute();
        }
        redirectPage("./index.php");
    }


    function updateCategory($id, $name){
        $query = "UPDATE categories SET Name='$name' WHERE id=$id";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->execute();
        
        redirectPage("./index.php");
    }

    
    function updateItem($id, $name, $length, $status){
        $query = "UPDATE lists SET nameOrContent='$name', length='$length', status='$status' WHERE id=$id";
        $conn = $GLOBALS['db']->prepare($query);
        $conn->execute();
        
        redirectPage("./index.php");
    }


    function getParsedUrl(){
        return parse_url("http://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI']);
    }

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