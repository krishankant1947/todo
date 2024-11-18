<?php
require "config.php";
$edit_data=[];
$array=array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$sql= "insert into todo(name) value(?)";
$stmt=$pdo->prepare($sql);
$stmt->execute([$_POST['todolist']]);
header('location:index.php');
die;
}
if(!empty($_GET['action'])){
    if($_GET['action']=='edit'){
        $id=$_GET['id'];
        $sql="select * from todo where name=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        $edit_data=$stmt->fetch(PDO::FETCH_ASSOC);
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
           
            <main class="m-3">
                <div class="row my-2">
                    <div class="col-9">
                        <input type="text" name="todolist" class="form-control" id="todo" placeholder="...." >
                    </div>
                    <div class="col-3">
                    <button type="submit" class="btn btn-outline-success">submit</button>
                    </div>
                </div>
            </main>
            <div style="height: 200px; overflow:auto" class="mb-3">
            <table class="table table-striped ">
                <?php
                $sql="select * from todo";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
                // print_r($rows);
                foreach ($rows as $row) {
                    echo <<<TODO
                    <tr>
                        <td>{$row['name']}</td>
                        <td class="text-end" ><a href="index.php?action=delete&id={$row['id']}"><button class="btn btn-danger ">DELETE</button></a>
                        <a href=""></a></td>
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