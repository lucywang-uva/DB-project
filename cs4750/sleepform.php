<?php
session_start();
require('connect-db.php');
require('food_db.php');
//ob_start();


$list_of_entries = getAllSleepEntries($_SESSION['username']);
$sleep_to_update = null;
$sleep_to_delete = null;

checkSleep();


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {  
      // If the button is clicked and its value is "Add" then call addFriend() function
      $maxSleepID = getMaxSleepID();
      $newFoodID = $maxSleepID['MAX(sleep_id)'] + 1;

     



      addSleepEntry($newFoodID, $_POST['date'], $_POST['hoursSlept']);
      addSleepCreateEntry($newFoodID, $_SESSION['username']);
      $list_of_entries = getAllSleepEntries($_SESSION['username']);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {  
      // If the button is clicked and its value is "Update" then retrieve info about that friend.
      // We'll later fill in the friend's info in the form so that a user can update the info.
      
      $sleep_to_update = getSleep_byID($_POST['sleep_to_update']);

      // To fill in the form, assign the pieces of info to the value attributes of form input textboxes.
      // Then, we'll wait until a user makes some changes to the friend's info 
      // and click the "Confirm update" button to actually make it reflect the database. 
      // (also note: "name" is a primary key -- refer to the friends table we created, thus can't be updated)
    }









  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Default") {
      $list_of_entries = getAllSleepEntries($_SESSION['username']);
  }

  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Hours Slept (Ascending)") {
      $list_of_entries = sortSleepAsc($_SESSION['username']);
  }

  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Hours Slept (Descending)") {
      $list_of_entries = sortSleepDesc($_SESSION['username']);
  }  









    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete") {
        deleteSleepEntry($_POST['sleep_to_delete']);
        deleteCreateSleepEntry($_POST['sleep_to_delete']);
        $list_of_entries = getAllSleepEntries($_SESSION['username']);
  }
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update") {
        updateSleepEntry($_POST['sleep_id'], $_POST['date'], $_POST['hoursSlept']);
        $list_of_entries = getAllSleepEntries($_SESSION['username']);
    }
    
}
$sleep = getSleep($_SESSION['username']);
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
echo 'Welcome, '.$_SESSION['username'].'! <br>';
echo "Today is " . date("Y-m-d") . "<br>";
?>

<body>
<div class="container">
    <h4 style='text-align:right'>Daily Sleep Target: <b><?php echo $sleep['daily_sleep_time'] ?> hours</b></h4>  
  <h1 style= "vertical-align:middle; text-align:center; font-size: 80px; font-family: 'Courier New', monospace; color:black">Sleep Entries</h1>  

  <form name="mainForm" action="sleepform.php" method="post">   

  <div class="row mb-3 mx-3">
    <input type="hidden" class="form-control" name="sleep_id" required 
            value="<?php if ($sleep_to_update!=null) echo $sleep_to_update['sleep_id'] ?>"
    />        
  </div>


   <div class="row mb-3 mx-3">
   <div style="text-align:center">
   <label>Date:</label>
   <span>
    <input type="date" class="form-control" name="date" required 
            value="<?php if ($sleep_to_update!=null) echo $sleep_to_update['date'] ?>"
    />
    </span>
  </div>
  </div>


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Hours Slept:</label>
  <span>
    <input type="number" class="form-control" name="hoursSlept" required 
            value="<?php if ($sleep_to_update!=null) echo $sleep_to_update['hoursSlept'] ?>"
    />   
    </span>
  </div>     
  </div>  

  

 

</div>  

<div class="center">
  <input type="submit" value="Add" name="btnAction" class="btn btn-outline-primary" 
        title="insert entry" align: 'center'; class='text=center' style ="text-align: center; color:blue;  font-size: 20px; font-family: 'Courier New', monospace; width: 100px" />  
  <input type="submit" value="Confirm update" name="btnAction" class="btn btn-outline-primary" 
        title="update entry" align: 'center'; class='text=center' style ="text-align: center; color:blue;  font-size: 20px; font-family: 'Courier New', monospace; width: 250px" />  
        </div>
</form>    

<hr/>



<div class="center">
  <form action="sleepform.php" method="post">
<span>
Sort by: 
<input type="submit" value="Default" name="btnAction" class="btn btn-outline-info" style="width:100px" />
    <input type="submit" value="Hours Slept (Ascending)" name="btnAction" class="btn btn-outline-info" style="width:250px" />
    <input type="submit" value="Hours Slept (Descending)" name="btnAction" class="btn btn-outline-info" style="width:250px" />
</span>
</div>
</form>

&nbsp;

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">      
    <th width="15%">Date</th>        
    <th width="15%">Hours Slept</th> 
    <th width="12%">Update</th>  
    <th width="12%">Delete</th> 
  </tr>
  </thead>
  <?php foreach ($list_of_entries as $entry): ?>
  <tr>
    <td><?php echo $entry['date']; ?></td>
    <td><?php echo $entry['hoursSlept']; ?></td>
    <td>
      <form action="sleepform.php" method="post">
        <input type="submit" value="Update" name="btnAction" class="btn btn-primary" style="width:120px" />
        <input type="hidden" name="sleep_to_update" value="<?php echo $entry['sleep_id'] ?>" />      
      </form>
    </td>
    <td>
    <form action="sleepform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" style="width:100px" />
        <input type="hidden" name="sleep_to_delete" value="<?php echo $entry['sleep_id'] ?>" />      
      </form>
    
    
    </td> 
  </tr>
  <?php endforeach; ?>

  
  </table>
</div>  


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>