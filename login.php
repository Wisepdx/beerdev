<?php
   include("connect.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($conn,$_POST['username']);
      $mypassword = mysqli_real_escape_string($conn,$_POST['password']);

      $sql = "SELECT id FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count == 1) {
         session_start();
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;

         header("location: index.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>




<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wisepdx Beer Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--Custom CSS -->
    <style type='text/css'>
      body{
        background-color: #333333;
      }
    </style>
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- jQuery -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>
      <div class='container' align = "center">
        <div class='col-md-4 col-md-offset-4'>
               <img src="images/owlWhite.png" class="img-responsive center-block" alt="Responsive image">
               <form class="form-signin" action = "" method = "post">
                  <h2 class="form-signin-heading">Login</h2>
                  <div class="form-group">
                    <!-- <label for="UNfield">UserName:</label> -->
                    <input id="UNfield" type = "text" name = "username" class="form-control" placeholder="Username" required autofocus/>
                  </div>
                  <div class="form-group">
                    <!-- <label for="PWfield">Password:</label> -->
                    <input id="PWfield" type = "password" name = "password" class="form-control" placeholder="Password" required/>
                  </div>
                  <input class="btn btn-lg btn-primary btn-block" type="submit" value="Submit"/><br />
               </form>


               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
             </div>
      </div>

   </body>
</html>
