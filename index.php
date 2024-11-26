<?php
require "config.php";
$array=array();
$edit_data=[];

$message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_POST['todolist'])){
        $message = "<div class='alert alert-anger'>cdbjnx</div>";
    }else{
        echo '<pre>';
        // print_r($_POST);
        // die;
        if(empty($_GET['id'])){
            $sql="insert into todo(name) value(?)";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$_POST['todolist']]);
    
            echo $todo_id = $pdo->lastInsertId();
            $tag_ids = $_POST['tags'];
    
            $sql = "insert into tags_todo(tags_id, todo_id) value(:tag_id, :todo_id)";
            foreach($tag_ids as $tag_id){
    
                $stmt=$pdo->prepare($sql);
                $stmt->execute([
                    'tag_id'=> $tag_id,
                    'todo_id'=> $todo_id
                ]);
            }
        }
        else{
            $id=$_GET['id'];
            $sql="update todo set name=? where id=?";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$_POST['todolist'] ,$id] );

            $tag_unlink_stmt = $pdo->prepare('delete from tags_todo where todo_id=?');
            $tag_unlink_stmt->execute([$id]);
            $tag_ids = $_POST['tags'];

            $sql = "insert into tags_todo(tags_id, todo_id) value(:tag_id, :todo_id)";
            foreach($tag_ids as $tag_id){

                $stmt=$pdo->prepare($sql);
                $stmt->execute([
                    'tag_id'=> $tag_id,
                    'todo_id'=> $id
                ]);
            }
        }


        header('location:index.php');
        die;
   }
   if(empty($array)){
    if(empty($_GET['id'])==false){
        $sql="update todo set name=? where id=?";
    }
    else{
        $sql="insert into todo(name) value(?)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$_POST['todolist']]);
    }
    header('location:index.php');
    die;
   }
}
if(!empty($_GET['action'])){
    if($_GET['action']=='edit'){
        echo "rjvfckm";
        $id=$_GET['id'];
        $sql="select name as todolist from todo where id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        $_POST=$stmt->fetch(PDO::FETCH_ASSOC);
    }
    else {
        $sql="delete from todo where id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$_GET['id']]);
        header("location:index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style type="text/css">
        .todo{
            background-image: url(background.jpg);
            background-size: cover;
            color: white;
        }
        .table-striped>tbody>tr:nth-of-type(odd)>*{
            background-color: #e9ecef;
        }
        .todolist{
            background-color: white;
        }
    </style>
</head>
<body>
   <form action="" method="post">
    <header class="todo ">
        <div class="row">
            <div class="col-6 m-4 text-end ">
                <h2 class="">TODO</h2>
            </div>
            <div class="col-6">
                <img src="">
            </div>
        </div>
    </header>
    <section class="todolist">
    
    <div class="row">
        <div class="col-4 offset-4 border border-secondary bg-warning-subtle ">
            <?php echo $message; ?>
            <main class="m-3">
                <div class="row my-2">
                    <div class="col-9">
                        <label for="todo">Todo</label>
                        <input type="text" name="todolist" class="form-control" id="todo" value="<?php echo empty($_POST['todolist']) ? '' : $_POST['todolist'];

                        ?>" placeholder="...." >
                    </div>
                    <div class="col-3">
                    <button type="submit" class="btn btn-outline-success">submit</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">               
                          <label for="tags">Tags</label>
                        <select size="5" multiple name="tags[]" class="form-control" id="tags">
                             <option value="">-- select -- </option>
 <?php            $sql="select * from tags";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $sql="select tags_id from tags_todo where todo_id =?";
                $stmt=$pdo->prepare($sql);
                $stmt->execute([$_GET['id']]);
                $COL=$stmt->fetchAll(PDO::FETCH_COLUMN,0);
                var_dump($COL);
                foreach($rows as $row){
                    $isselected= in_array($row['id'], $COL );
                    $selected_text = '';
                    if($isselected){
                        $selected_text = " selected ";
                    }
                echo<<<MANAGER

                        <option value="{$row['id']}" {$selected_text}>{$row['title']}</a>

                MANAGER;
                }
                ?></select>
                    </div>
                </div>
            </main>
            <div style="height: 200px; overflow:auto" class="mb-3">
            <table class="table table-striped ">
                <?php
                // $sql="select * from todo";
                $sql = 'SET sql_mode = ""';
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                $sql="select todo.*,group_concat(t.id) as tag_id , group_concat(t.title) as tag_title  from 
                    todo left join tags_todo ON(todo.id=tags_todo.todo_id)
                    left join tags t ON(t.id=tags_todo.tags_id)
                    group by todo.id
                   
                    ";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
// echo '<pre>';
//                 print_r($rows);die;
                foreach ($rows as $row) {
                    echo <<<TODO
                    <tr>
                        <td>{$row['name']} <small>{$row['tag_title']}</small></td>
                        <td class="text-end" ><a href="index.php?action=edit&id={$row['id']}"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="index.php?action=delete&id={$row['id']}"><button type="button" class="btn btn-danger ">DELETE</button></a>
                        </td>
                    </tr>
                    TODO;
                }


?></table>
            </div>
                <div>
                    
                </div>
            </section>
        </div>
    </div>
   </form> 
</body>
</html>