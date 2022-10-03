<?php 
    include_once './functions/functions.php';

    function editCategory($item){
        include_once './parts/head.php';
        ?>
            <a href="./index.php"><button class="button">back</button></a>
            <form action="./edit.php?type=category&id=<?php echo $_GET['id']; ?>" method="post">
                <Label>Naam:</Label>
                <input class="input is-primary" type="text" name="name" id="" value="<?php echo $item['Name'] ?>" required>
                <input type="submit" class="button">
            </form>
        <?php
    }


    function editItem($item){
        include_once './parts/head.php';
        ?>
        
            <a href="./index.php"><button class="button">back</button></a>
            <form action="./edit.php?type=item&id=<?php echo $_GET['id']; ?>" method="post">
                <Label>Naam:</Label>
                <input class="input is-primary" type="text" name="name" id="" value="<?php echo $item['nameOrContent'] ?>" required>
                <label>Lengte:</label>
                <input class="input is-primary" type="number" name="length" id="" value="<?php echo $item['length'];?>" required>

                <label>status:</label>

                <select name="status" class="input is-primary">
                    <option value="completed">completed</option>
                    <option value="working">working</option>
                    <option value="open">open</option>
                </select>

                <input type="submit" class="button">
            </form>
        <?php
    }    



    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_GET['type']) && isset($_GET['id'])){
            $type = $_GET['type'];
            $id = $_GET['id'];
            var_dump($_POST);
            
            switch($type):

                case 'category':
                    updateCategory($id, $_POST['name']);     

                break;

                case 'item':
                    updateItem($id, $_POST['name'], $_POST['length'], $_POST['status']);
                break;

                default:
                    redirectPage("./index.php");
            endswitch;
            
        }
    }

    else{
        if(isset($_GET['type']) && isset($_GET['id'])){
            $id = $_GET['id'];
            $type = $_GET['type'];

            switch($type):
                case 'category':
                        $item = getSingleCategory($id);                                
                        editCategory($item[0]);
                    break;
                
                case 'item':
                        $item = getSingleItem($id);
                        editItem($item[0]);
                    break;

                default:
                    redirectPage("./index.php");
                    break;
            endswitch;
        }
        else{
            redirectPage("./index.php");
        }
    }
?>