<?php
    require('connect.php');
    session_start();

    $error = '';
    $validate = '';
    if(isset($_SESSION['username'])) header('location: index.php');
    if(isset($_POST['submit'])){  
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        
        // Cek Input Username & Password
        if(!empty(trim($username)) && !empty(trim($password))){
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $query);
            $rows = mysqli_num_rows($result);
            if ($rows != 0) {
                $hash   = mysqli_fetch_assoc($result)['password'];
                // Cek kesamaan password
                if(password_verify($password, $hash)){
                    $_SESSION['username'] = $username;
                    // Cek Kode Captcha
                    if ($_SESSION["code"] != $_POST['captcha']){
                        $error = 'Kode Captcha Salah !!';
                    } else {
                        header('Location: index.php');
                    }
                } else {
                    $error = 'Password anda salah !!';
                }
            } else {
                $error = 'Login User Gagal !!';
            }
        }else {
            $error = 'Data tidak boleh kosong !!';
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="css/login.css">
<title>Login User</title>
</head>
<body>
    <section class="container-fluid mb-4">
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-4">
                <form class="form-container" action="login.php" method="POST">
                    <h4 class="text-center font-weight-bold"> Sign-In </h4>
                    <?php if($error != ''){ ?>
                        <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Password</label>
                        <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
                        <?php if($validate != '') {?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php }?>
                    </div>
                    <div class="form-group">
                        <label for="captcha">Captcha</label><br>
                        <img src="captcha.php" alt="gambar-captcha">
                    </div>
                    <div class="form-group">
                        <label for="captcha">Input Captcha</label>
                        <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Masukkan Captcha">  
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                    <div class="form-footer mt-2">
                        <p> Belum punya account? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </section>
        </section>
    </section>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>