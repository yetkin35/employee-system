<?php 
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials/assets.php';?>
    <title>Gibson Company</title>
</head>
<body>
    <?php
      /*if(isset($_SESSION["permissionPersonnel"]) && $_SESSION["permissionPersonnel"] == true){
        echo "<script>location.href = 'personnels.php'</script>";
      }
      if(isset($_SESSION["permissionEvaluator"]) && $_SESSION["permissionEvaluator"] == true){
        echo "<script>location.href = 'evaluators.php'</script>";
      }*/

      if(isset($_POST['password']) && isset($_POST['username'])){
        $sql = "SELECT * FROM evaluators";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              if(isset($_POST['password']) && isset($_POST['username']) && $_POST['username'] == $row["username"] && $_POST['password'] == $row["password"] ){
                $_SESSION["permissionEvaluator"] = true;
                $_SESSION["idEvaluator"] = $row["id"];
                $_SESSION["permissionPersonnel"] = false;
                echo "<script>location.href = 'evaluators.php'</script>";
              }

              echo "<script>setTimeout(function(){ 
                              swal({
                                type: 'error',
                                title: 'Login error', 
                                text: 'Wrong username or password!'
                              });
                            }, 300);
                    </script>";
            }
        }else {
          $_SESSION["permissionEvaluator"] = false;
          $_SESSION["permissionPersonnel"] = false;
          echo "<script>console.log('error');</script>";
        }

        $sql = "SELECT * FROM personnels";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              if(isset($_POST['password']) && isset($_POST['username']) && $_POST['username'] == $row["username"] && $_POST['password'] == $row["password"] ){
                $_SESSION["permissionPersonnel"] = true;
                $_SESSION["idPersonnel"] = $row["id"];
                $_SESSION["permissionEvaluator"] = false;
                echo "<script>location.href = 'personnels.php'</script>";
              }
              echo "<script>setTimeout(function(){ 
                              swal({
                                type: 'error',
                                title: 'Login error', 
                                text: 'Wrong username or password!'
                              });
                            }, 300);
                    </script>";
            }
        }else {
          $_SESSION["permissionEvaluator"] = false;
          $_SESSION["permissionPersonnel"] = false;
          echo "<script>alert('error');</script>";
        }
      } 
    ?>
    <div class="container">
        <section class="col-md-12 content" id="home">
           <div class="col-lg-6 col-md-6 content-item tm-black-translucent-bg tm-logo-box">
              <img src="images/gibson.png" style="width: 20vw;height: 10vw;">
           </div>
           <div class="col-lg-6 col-md-6 content-item content-item-1 background tm-white-translucent-bg">
               <h1 class="main-title text-center dark-blue-text" style="font-size: 72px;margin-top: 5px">Welcome</h1>
               <form action="index.php" method="POST">
                <div class="form-group">
                  <label for="exampleInputUsername1">Username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
              </form> 
              </div>       
           </div>
       </section>
    </div>

<div class="text-center footer">
  <div class="container">
    Copyright 2018 | Design: <a href="http://www.instagram.com/yetkinyurtsever" target="_blank">Yetkin Yurtsever</a>
    </div>
</div>
</body>
</html>