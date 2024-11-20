<?php
require "config.php";
$array=array();
$edit_data=[];

                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if(empty($_POST['todomanager'])){
                        $array[]="enter your detaile";
                        
                    }
                    if(empty($array)){
                        $sql="insert into todomanager(title) value(?)";
                        $stmt=$pdo->prepare($sql);
                        $stmt->execute([$_POST['todomanager']]);
                        header('location:todomanager1.php');
                    }
                    }
                    
                
if(!empty($_GET['action'])){
    if($_GET['action']=='edit'){
        $id=$_GET['id'];
        $sql="select * from todomanager where title=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        $edit_data=$stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
        $sql="delete from todomanager where id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$_GET['id']]);
        header("location:todomanager1.php");
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
        .todo_manager{
            background-image: url(background.jpg);
            color:white;
        }
        .todomanager{
            background-color: #8ecae6;
    ;    }
    </style>
</head>
<body>
    <form action="" method="post">
    <header class="todo_manager ">
        <div class="row">
            <div class="col-6 m-4 text-end ">
                <h2 class="">TODO_MANAGER</h2>
            </div>
            <div class="col-6">
                <img src="">
            </div>
        </div>
    </header>
       
       <div class="row my-4">
            <div class="col-4 offset-4 border border-secondary shadow-lg p-3 mb-5 bg-body-tertiary rounded ">
            <section class="todomanager">
                <?php
                if(!empty($array)){
                    echo '<div class="alert alert-danger my-3">empty values are not allowed</div>';
                }
                ?>
                <div class="row m-3">
                    <div class="col-9 ">
                        <input type="text" name="todomanager" class="form-control" id="todo_manager">
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-outline-success">submit</button>
                    </div>
                </div>
       </section>
               <table  class="table table-striped">
               <?php
                $sql="select * from todomanager";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($rows as $row)
                echo<<<MANAGER
                    <tr>
                        <td>{$row['title']}</td>
                        <td class="text-end my-3"><a href="todomanager1.php?action=delete&id={$row['id']}"><button type="button" class="btn btn-info ">DELETE</button></a>
                        <a href=""></a></td>
                    </tr>
                MANAGER;
                ?>
               </table>
            </div>
        </div>
    </form>
</body>
</html>