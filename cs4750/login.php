<?php
error_reporting(0);
session_start();
require('connect-db.php');
require('food_db.php');
//ob_start();

$current_user = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Login")
    {       

            

    
            $current_user = getUser($_POST['username']); 
            if ($current_user['username'] != null) { //if username exists, get the posted password
                $current_pass = getPass($_POST['username']); //get password of that username
                $_SESSION['password'] = $current_pass['password']; //set session password to password of username
                if (password_verify($_POST['password'], $_SESSION['password'])) {
                    $_SESSION['username'] = $current_user['username'];
                    $_SESSION['password'] = $current_pass['username'];
                    header("Location: foodform.php");
                    exit();
                }
            }
            else {
                echo "login failed, please try again.";
            }
        }


}
    

?>






<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.
   
  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded   
  -->
  
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>DB interfacing example</title>
  
  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- you may also use W3's formats -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  
  <!-- 
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource. 
  -->
  
  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  
  <!-- if you choose to download bootstrap and host it locally -->
  <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> --> 
  
  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->
       
</head>

<style>
body {
  background-image: url('background.jpg');
}
</style>



<body>
<div class="container">
    <div class="center">
  <h1 style= "vertical-align:middle; text-align:center; font-size: 80px; font-family: 'Courier New', monospace; color:black">Login</h1>  

  <form name="mainForm" method="post">   


  <div class="row mb-3 mx-3">
    <div style="text-align:center">
        <label>Username: <label>
        <span>
        <input type="text" class="form-control" name="username" 
        /> 
        </span> 
</div>    
  </div>
 

   <div class="row mb-3 mx-3" >
        <div style="text-align:center">
   <label> Password: <label>
    <input type="password" class="form-control" name="password" 
    />
    </div>
  </div>

  </div>
 

</div>  
<div style="text-align:center">
  <input type="submit" value="Login" name="btnAction" class="btn btn-outline-primary"
        title="login" align: 'center'; class='text=center' style ="text-align: center; color:blue;  font-size: 25px; font-family: 'Courier New', monospace;" />  
</div>

  
</form>    

<hr/>

<!-- </div>   -->


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>