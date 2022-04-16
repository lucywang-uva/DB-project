<?php
error_reporting(0);
session_start();
require('connect-db.php');
require('food_db.php');
//ob_start();


$rating = null;
$rating_to_update = null;

checkRating();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Submit")
    {  
            $rating_exists = checkRatingExists($_SESSION['username']);
            echo $rating_exists['count(*)'];
            if ($rating_exists['count(*)'] == 0) { //rating does not exists, add rating and remove submit button
                $maxRatingID = getMaxRatingID();
                $newRatingID = $maxRatingID['MAX(rating_id)'] + 1;
                
                insertRating($newRatingID,  $_POST['value']);
                insertMake($newRatingID, $_SESSION['username']);
                $rating = getRating($_SESSION['username']);
                $avg_rating = getAverageRating();
            }         
    }   


    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update") {
            $rating = getRating($_SESSION['username']); //rating_id, value, username
            $rating_to_update = getRating_byID($rating['rating_id']);
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update") {
        updateRating($_POST['rating_id'], $_POST['value']);
        $rating = getRating($_SESSION['username']);
        $avg_rating = getAverageRating();
    }
    
    

        
}

$rating = getRating($_SESSION['username']);
$my_rating = $rating['value'];
$avg_rating = getAverageRating();
    

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
  <link rel="stylesheet" href="custom.css" /> 
       
</head>



<style>
body {
  background-image: url('background.jpg');
}
</style>




<div class="topnav">
  <a href="http://localhost/cs4750/foodform.php">Food Entries</a>
  <a href="http://localhost/cs4750/exerciseform.php">Exercise Entries</a>
  <a href="http://localhost/cs4750/sleepform.php">Sleep Entries</a>
  <a href="http://localhost/cs4750/rating.php">Rate Us!</a>
  <div class="topnav-right">
    <a href="http://localhost/cs4750/settings.php">Settings</a>
    <a href="http://localhost/cs4750/home.php">Logout</a>
  </div>
 
</div>



<?php
echo 'Welcome, '.$_SESSION['username'].'! <br>' ;
echo "Today is " . date("Y-m-d") . "<br>";
?>




<body>
<div class="container">
  <h1 style= "vertical-align:middle; text-align:center; font-size: 80px; font-family: 'Courier New', monospace; color:black">Rate Us!</h1>  

  <form name="mainForm" method="post">   


  <div class="row mb-3 mx-3">
    <input type="hidden" class="form-control" name="rating_id" 
    value="<?php if ($rating_to_update!=null) echo $rating_to_update['rating_id'] ?>"
    />        
  </div>


  <div class="row mb-3 mx-3">
    Rating:
    <input type="number" class="form-control" name="value" require min="1" max="5"
    value="<?php if ($rating_to_update!=null) echo $rating_to_update['value'] ?>"
    />        
  </div>

 

</div>  



<div style="text-align:center">
  <input type="submit" value="Submit" name="btnAction" class="btn btn-outline-primary"
        title="submit" align: 'center'; class='text=center' style ="text-align: center; color:blue;  font-size: 25px; font-family: 'Courier New', monospace; width:180px" />  
&nbsp;
  <input type="submit" value="Update" name="btnAction" class="btn btn-outline-primary" title="update" align: 'center'; class='text=center' style ="text-align: center; color:blue;  font-size: 25px; font-family: 'Courier New', monospace; width:180px"" />  
  <input type="hidden" name="rating_to_update" value="<?php echo $rating['rating_id'] ?>"  />
&nbsp;
<input type="submit" value="Confirm update" name="btnAction" class="btn btn-outline-primary" 
        title="confirm update" align: 'center'; class='text=center' style ="text-align: center; color:blue;  font-size: 25px; font-family: 'Courier New', monospace; width:250px"" />  
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


<body>
<div class="container">
    <div class="row mb-3 mx-3">
        <span>
        <label style="font-size:30px; text-align:center">My rating: <?php echo $my_rating; ?></label>

</span>
    </div>



    <div class="row mb-3 mx-3">
    <span>
    <label style="font-size:30px; text-align:center">Overall rating:  <?php echo $avg_rating['AVG(value)']; ?></label>
   
</span>
  </div>
</div>
     
</body>