<?php  
session_start();
unset($_SESSION['username']);
$error = '';

if (isset($_POST['username'])&&isset($_POST['password'])) {
    if($_POST['username']==''||$_POST['password']=='')
    {
        $error='<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Vui lòng nhập đầy đủ tài khoản và mật khẩu!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    }else{
        require 'mySQL.php';
        $query="SELECT * FROM nguoidung WHERE username = :username AND password = :password";
        $statement=$conn->prepare($query);
        $statement->execute(
            [
                'username'=>$_POST['username'],
                'password'=>$_POST['password']
            ]
        );
        $count=$statement->rowCount();
        if($count > 0)
        {
            $_SESSION['username'] = $_POST['username'];
            header('location:sanpham.php');
        }else
        {   
            $error='<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Tài khoản hoặc mật khẩu sai.Vui lòng nhập lại!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>';
        }
    }       
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="Demo project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require 'code/style.php' ?>

    
</head>
<body>
    <br>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-white mb-4">Login Form</h2>
                <div class="row">
                    <div class="col-md-6 mx-auto">

                        <!-- form card login -->
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="mb-0">Login</h3>
                            </div>
                            <div class="card-body">
                                <form class="form" role="form" autocomplete="off" id="formLogin" novalidate="" method="post" action="login.php">
                                    <div class="form-group">
                                        <label for="uname1">Username</label>
                                        <input type="text" class="form-control form-control-lg rounded-0" name="username" placeholder="username">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control form-control-lg rounded-0" name="password" placeholder="password">
                                    </div>
                                    <?php if($error!='') { ?> 
                                        <label for="" style="color:red"><?=$error?></label>
                                    <?php }?>
                                    <input type="submit" class="btn btn-success btn-lg float-right" value="Login" name="login">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>