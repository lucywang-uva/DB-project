<?php
error_reporting(0);
session_start();
require('connect-db.php');
require('food_db.php');
//ob_start();

    
$date = date("Y-m-d");
$list_of_entries = getAllEntries($_SESSION['username'], $_SESSION['date']);
$food_to_update = null;
$food_to_delete = null;
$foodgroup_to_update = null;
$foodgroup1 = null;
$foodgroup2 = null;
$foodgroup3 = null;
$foodgroup4 = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $date = $_POST['date'];
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {  
      $maxFoodID = getMaxFoodID();
      $newFoodID = $maxFoodID['MAX(food_id)'] + 1;
      // If the button is clicked and its value is "Add" then call addFriend() function

      addFoodEntry($newFoodID, $_POST['date'], $_POST['food'], $_POST['calories'], $_POST['timeEaten']);
      addFoodCreateEntry($newFoodID, $_SESSION['username']);

      if ($_POST['food_group1'] != null) {
        addFoodGroup($newFoodID, $_POST['food_group1']);
      }

      if ($_POST['food_group2'] != null) {
        addFoodGroup($newFoodID, $_POST['food_group2']);
      }

      if ($_POST['food_group3'] != null) {
        addFoodGroup($newFoodID, $_POST['food_group3']);
      }

      if ($_POST['food_group4'] != null) {
        addFoodGroup($newFoodID, $_POST['food_group4']);
      }

      $list_of_entries = getAllEntries($_SESSION['username'], $_SESSION['date']);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {  
      // If the button is clicked and its value is "Update" then retrieve info about that friend.
      // We'll later fill in the friend's info in the form so that a user can update the info.
      $food_to_update = getFood_byID($_POST['food_to_update']); //returns single row
      $foodgroup_to_update = getFoodGroup($_POST['food_to_update']);

      
      
      
    

      // To fill in the form, assign the pieces of info to the value attributes of form input textboxes.
      // Then, we'll wait until a user makes some changes to the friend's info 
      // and click the "Confirm update" button to actually make it reflect the database. 
      // (also note: "name" is a primary key -- refer to the friends table we created, thus can't be updated)
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Submit") {
      $_SESSION['date'] = $_POST['date'];
      $list_of_entries = getAllEntries($_SESSION['username'], $_SESSION['date']);
    }

    
    
    
    
    
    
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Default") {
      $list_of_entries = getAllEntries($_SESSION['username'], $_SESSION['date']);
  }

  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Food Name") {
      $list_of_entries = sortFoodName($_SESSION['username'], $_SESSION['date']);
  }

  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Calories (Ascending)") {
      $list_of_entries = sortFoodCalAsc($_SESSION['username'], $_SESSION['date']);
  }

  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Calories (Descending)") {
      $list_of_entries = sortFoodCalDesc($_SESSION['username'], $_SESSION['date']);
  }  
    
    
    
    
    
    
    
    
    
    
    
    
    
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete") {
        deleteEntry($_POST['food_to_delete']);
        deleteCreateEntry($_POST['food_to_delete']);
        deleteFoodGroups($_POST['food_to_delete']);
        $list_of_entries = getAllEntries($_SESSION['username'], $_SESSION['date']);
  }

    
  
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update") {

      $food_to_update2 = getFood_byID($_POST['food_id']); //returns single row
      $foodgroup_to_update2 = getFoodGroup($_POST['food_id']); //all foodGroup with certain food_id
      $foodGroupCount = getFoodGroupCount($_POST['food_id']);
      

      for ($k = 0; $k < 4; $k++) { 
        if (($k == 0 && $foodGroupCount['count(*)'] >= 1) || ($_POST['food_group1'] != null)) {
          if ($foodgroup_to_update2[0]['foodGroup'] != null && $_POST['food_group1'] != null) {
            updateFoodGroup($food_to_update2['food_id'], $_POST['food_group1'], $foodgroup_to_update2[0]['foodGroup']);
          }
          if ($foodgroup_to_update2[0]['foodGroup'] == null && $_POST['food_group1'] != null) { //add
            addFoodGroup($food_to_update2['food_id'], $_POST['food_group1']);
          }
          if ($foodgroup_to_update2[0]['foodGroup'] != null && $_POST['food_group1'] == null) { //delete
            deleteFoodGroup($food_to_update2['food_id'], $foodgroup_to_update2[0]['foodGroup']);
          }

        }
        if (($k == 1 && $foodGroupCount['count(*)'] >= 2) || ($_POST['food_group2'] != null)) {
          if ($foodgroup_to_update2[1]['foodGroup'] != null && $_POST['food_group2'] != null) {
            updateFoodGroup($food_to_update2['food_id'], $_POST['food_group2'], $foodgroup_to_update2[1]['foodGroup']);
          }
          if ($foodgroup_to_update2[1]['foodGroup'] == null && $_POST['food_group2'] != null) { //add
            addFoodGroup($food_to_update2['food_id'], $_POST['food_group2']);
          }
          if ($foodgroup_to_update2[1]['foodGroup'] != null && $_POST['food_group2'] == null) { //delete
            deleteFoodGroup($food_to_update2['food_id'], $foodgroup_to_update2[1]['foodGroup']);
          }
          
        }
        if (($k == 2 && $foodGroupCount['count(*)'] >= 3) || ($_POST['food_group3'] != null)) {
          if ($foodgroup_to_update2[2]['foodGroup'] != null && $_POST['food_group3'] != null) {
            updateFoodGroup($food_to_update2['food_id'], $_POST['food_group3'], $foodgroup_to_update2[2]['foodGroup']);
          }
          if ($foodgroup_to_update2[2]['foodGroup'] == null && $_POST['food_group3'] != null) { //add
            addFoodGroup($food_to_update2['food_id'], $_POST['food_group3']);
          }
          if ($foodgroup_to_update2[2]['foodGroup'] != null && $_POST['food_group3'] == null) { //delete
            deleteFoodGroup($food_to_update2['food_id'], $foodgroup_to_update2[2]['foodGroup']);
          }
          
        }
        if (($k == 3 && $foodGroupCount['count(*)'] >= 4) || ($_POST['food_group4'] != null)) {
          if ($foodgroup_to_update2[3]['foodGroup'] != null && $_POST['food_group4'] != null) {
            updateFoodGroup($food_to_update2['food_id'], $_POST['food_group4'], $foodgroup_to_update2[3]['foodGroup']);
          }
          if ($foodgroup_to_update2[3]['foodGroup'] == null && $_POST['food_group4'] != null) { //add
            addFoodGroup($food_to_update2['food_id'], $_POST['food_group4']);
          }
          if ($foodgroup_to_update2[3]['foodGroup'] != null && $_POST['food_group4'] == null) { //delete
            deleteFoodGroup($food_to_update2['food_id'], $foodgroup_to_update2[3]['foodGroup']);
          }
          
        }
        
      }


 
      updateEntry($_POST['food_id'], $_POST['date'], $_POST['food'], $_POST['calories'], $_POST['timeEaten']);
      $list_of_entries = getAllEntries($_SESSION['username'], $_SESSION['date']);
    }



    
    
}
$calorie = getCalorie($_SESSION['username']);
$actualCalorie = getActualCalorie($_SESSION['username'], $_SESSION['date']);
$actualCalorieVal = $actualCalorie['SUM(calories)'];



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
  
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <!-- <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" /> -->
    
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
<h4 style='text-align:right'>Daily Calorie Intake Target: <b><?php echo $calorie['daily_calorie_intake'] ?> </b></h4>  
<h4 style='text-align:right'>Actual Calorie Intake: <b><?php echo $actualCalorieVal ?> </b></h4>  
  <h1 style= "vertical-align:middle; text-align:center; font-size: 80px; font-family: 'Courier New', monospace; color:black">Food Entries</h1>  

  <form name="mainForm" action="foodform.php" method="post">   

<div class="center">


  <div class="row mb-3 mx-3">
    <input type="hidden" class="form-control" name="food_id" required 
            value="<?php if ($food_to_update!=null) echo $food_to_update['food_id'] ?>"
    />        
  </div>

   <div class="row mb-3 mx-3">
   <div style="text-align:center">
   <label>Date:</label>
   <span>
    <input type="date" class="form-control" name="date" required 
            value="<?php if ($food_to_update!=null) echo $food_to_update['date'] ?>"
    />
</span>
</div>
  </div>


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Food:</label>
  <span>
    <input type="text" class="form-control" name="food" required 
            value="<?php if ($food_to_update!=null) echo $food_to_update['foodName'] ?>"
    />  
    </span>      
  </div>
  </div>  
  
  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Food Group 1:</label>
  <span>
    <input type="text" class="form-control" name="food_group1" 
            value="<?php if (count($foodgroup_to_update) > 0) { echo $foodgroup_to_update[0]['foodGroup'];
            }
            else {echo "";}?>"
    />      
    </span>  
  </div>
  </div>  


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Food Group 2:</label>
  <span>
    <input type="text" class="form-control" name="food_group2" 
            value="<?php if (count($foodgroup_to_update) > 1) { echo $foodgroup_to_update[1]['foodGroup'];
            }
            else {echo "";}?>"
    /> 
    </span>       
  </div>
  </div>  


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Food Group 3:</label>
  <span>
    <input type="text" class="form-control" name="food_group3" 
            value="<?php 
            if (count($foodgroup_to_update) > 2) { echo $foodgroup_to_update[2]['foodGroup'];
            }
            else {echo "";} ?>"
    />
    </span>        
  </div>
  </div>  


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Food Group 4:</label>
  <span>
    <input type="text" class="form-control" name="food_group4" 
            value="<?php if (count($foodgroup_to_update) > 3) { echo $foodgroup_to_update[3]['foodGroup'];
            }
            else {echo "";}?>"
    />     
    </span>   
  </div>
  </div>  

  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Calories:</label>
  <span>
    <input type="number" class="form-control" name="calories" required
            value="<?php if ($food_to_update!=null) echo $food_to_update['calories'] ?>"
    /> 
    </span>
  </div> 
  </div>   

  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Time Eaten:</label>
  <span>
    <input type="text" class="form-control" name="timeEaten" required 
            value="<?php if ($food_to_update!=null) echo $food_to_update['timeEaten'] ?>"
    />
          </span>
   
  </div>
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
      



<form action="foodform.php" method="post">
<span>
<label >Entries for:  </label>
<input type="date" name="date" value='<?php echo $_SESSION['date']?>' style="width:200px" />
<input type="submit" value="Submit" name="btnAction" class="btn btn-secondary" style="font-size: 12px; width:75px; height:30px;text-align:center" />
</span>
</form>


<div class="center">
<form action="foodform.php" method="post">
<span>
Sort by:
  <input type="submit" value="Default" name="btnAction" class="btn btn-outline-info" style="width:100px" />
    <input type="submit" value="Food Name" name="btnAction" class="btn btn-outline-info" style="width:120px" />
    <input type="submit" value="Calories (Ascending)" name="btnAction" class="btn btn-outline-info"  style="width:200px" />
    <input type="submit" value="Calories (Descending)" name="btnAction" class="btn btn-outline-info" style="width:200px" />
</span>
</div>
</form>

&nbsp;


<div class="row justify-content-center"> 
<table class="w3-table w3-bordered w3-card-4" style="width:90% ">
  <thead>
  <tr style="background-color:#B0B0B0">     
    <th width="15%">Date</th>        
    <th width="15%">Food</th>
    <th width="5%">Food Groups</th>
    <th width="5%"></th>
    <th width="5%"></th>
    <th width="10%"></th>
    <th width="15%">Calories</th> 
    <th width="15%">Time Eaten</th>
    <th width="12%">Update</th>  
    <th width="12%">Delete</th>
  </tr>
  </thead>
  <tr>
  <?php foreach ($list_of_entries as $entry): ?>
    <?php $count = 0; ?>
    <?php $foodGroup = getFoodGroup($entry['food_id']) ?>
    <td><?php echo $entry['date']; ?></td>
    <td><?php echo $entry['foodName']; ?></td>


    <?php foreach ($foodGroup as $foodEntry): ?>
      <?php $count = $count + 1; ?>
      <td><?php echo $foodEntry['foodGroup']; ?></td>
    <?php endforeach; ?>

    <?php for ($k = $count; $k < 4; $k++) { ?> 
      <td><?php echo ""; ?></td>
    <?php } ?>
    



     
    
  
  

  
      
      
    
  

    <td><?php echo $entry['calories']; ?></td>
    <td><?php echo $entry['timeEaten']; ?></td> 
    <td>
      <form action="foodform.php" method="post">
        <input type="submit" value="Update" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="food_to_update" value="<?php echo $entry['food_id'] ?>" style="width:100px"  />      
      </form>
    </td>
    <td>
    <form action="foodform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" />
        <input type="hidden" name="food_to_delete" value="<?php echo $entry['food_id'] ?>" style="width:100px" />      
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