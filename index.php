<?php
require "config.php";
$array=array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$sql= "insert into todo(name) value(?)";
$stmt=$pdo->prepare($sql);
$stmt->execute([$_POST['todolist']]);
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
    <style type="text/css">
        .todo{
            background-image: url(background.jpg);
            background-size: cover;
            color: white;
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
                    <div class="col-12">
                        <input type="text" name="todolist" class="form-control" id="todo" placeholder="....">
                    </div>
                </div>
            </main>
           
                <ul>
                    <li>
                        <label for="completecheckbox1">complete checkbox</label>
                        <input type="checkbox" name="complete_checkbox" checked id="completecheckbox1">
                    </li>
                    <li>
                        <label for="completecheckbox2">complete checkbox</label>
                        <input type="checkbox" name="complete_checkbox" checked id="completecheckbox2">
                    </li>
                    <li>
                        <label for="completecheckbox3">complete checkbox</label>
                        <input type="checkbox" name="complete_checkbox" checked id="completecheckbox3">
                    </li>
                    <li>
                        <label for="completecheckbox4">complete checkbox</label>
                        <input type="checkbox" name="complete_checkbox" checked id="completecheckbox4">
                    </li>
                    <li>
                        <label for="completecheckbox5">complete checkbox</label>
                        <input type="checkbox" name="complete_checkbox" checked id="completecheckbox5">
                    </li>
                </ul>
                <div>
                    <button type="submit" class="btn btn-outline-success">submit</button>
                </div>
            </section>
        </div>
    </div>
   </form> 
</body>
</html>