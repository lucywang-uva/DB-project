<?php
error_reporting(0);
session_start();
require('connect-db.php');
require('food_db.php');
//ob_start();




$date = date("Y-m-d");
$list_of_entries = getAllExEntries($_SESSION['username'], $date);
$ex_to_update = null;
$ex_to_delete = null;
$exercisegroup_to_update = null;
$exercisegroup1 = null;
$exercisegroup2 = null;
$exercisegroup3 = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $date = $_POST['date'];
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {  
      $maxExID = getMaxExID();
      $newExID = $maxExID['MAX(exercise_id)'] + 1;
      // If the button is clicked and its value is "Add" then call addFriend() function
      
      addExEntry($newExID, $_POST['date'], $_POST['exercise'], $_POST['calBurned'], $_POST['timeReps']);
      addExCreateEntry($newExID, $_SESSION['username']);

      if ($_POST['ex_group1'] != null) {
        addExGroup($newExID, $_POST['ex_group1']);
      }

      if ($_POST['ex_group2'] != null) {
        addExGroup($newExID, $_POST['ex_group2']);
      }

      if ($_POST['ex_group3'] != null) {
        addExGroup($newExID, $_POST['ex_group3']);
      }

      

      $list_of_entries = getAllExEntries($_SESSION['username'], $_POST['date']);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {  
      // If the button is clicked and its value is "Update" then retrieve info about that friend.
      // We'll later fill in the friend's info in the form so that a user can update the info.
      
      $ex_to_update = getEx_byID($_POST['ex_to_update']);
      $exercisegroup_to_update = getExerciseGroup($_POST['ex_to_update']);
      // To fill in the form, assign the pieces of info to the value attributes of form input textboxes.
      // Then, we'll wait until a user makes some changes to the friend's info 
      // and click the "Confirm update" button to actually make it reflect the database. 
      // (also note: "name" is a primary key -- refer to the friends table we created, thus can't be updated)
    }
    
    
    
    
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Submit") {
        $_SESSION['date'] = $_POST['date'];
        $list_of_entries = getAllExEntries($_SESSION['username'], $_SESSION['date']);
    }

    
    
    
    
    
    
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Default") {
        $list_of_entries = getAllExEntries($_SESSION['username'], $_SESSION['date']);
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Exercise Name") {
        $list_of_entries = sortExerciseName($_SESSION['username'], $_SESSION['date']);
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Calories Burned (Ascending)") {
        $list_of_entries = sortExerciseCalAsc($_SESSION['username'], $_SESSION['date']);
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Calories Burned (Descending)") {
        $list_of_entries = sortExerciseCalDesc($_SESSION['username'], $_SESSION['date']);
    }

    
    
    
    
    
    
    
    
    
    
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete") {
        deleteExEntry($_POST['ex_to_delete']);
        deleteCreateExEntry($_POST['ex_to_delete']);
        deleteExerciseGroups($_POST['ex_to_delete']);
        $list_of_entries = getAllExEntries($_SESSION['username'], $_SESSION['date']);
  }
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update") {
        
        $ex_to_update2 = getEx_byID($_POST['ex_id']); //returns single row
        $exercisegroup_to_update2 = getExerciseGroup($_POST['ex_id']); //all foodGroup with certain food_id
        $exerciseGroupCount = getExerciseGroupCount($_POST['ex_id']);
        
  
        for ($k = 0; $k < 4; $k++) { 
          if (($k == 0 && $exerciseGroupCount['count(*)'] >= 1) || ($_POST['ex_group1'] != null)) {
            if ($exercisegroup_to_update2[0]['muscleGroup'] != null && $_POST['ex_group1'] != null) {
              updateExGroup($ex_to_update2['exercise_id'], $_POST['ex_group1'], $exercisegroup_to_update2[0]['muscleGroup']);
            }
            if ($exercisegroup_to_update2[0]['muscleGroup'] == null && $_POST['ex_group1'] != null) { //add
              addExGroup($ex_to_update2['exercise_id'], $_POST['ex_group1']);
            }
            if ($exercisegroup_to_update2[0]['muscleGroup'] != null && $_POST['ex_group1'] == null) { //delete
              deleteExGroup($ex_to_update2['exercise_id'], $exercisegroup_to_update2[0]['muscleGroup']);
            }
  
          }
          if (($k == 1 && $exerciseGroupCount['count(*)'] >= 2) || ($_POST['ex_group2'] != null)) {
            if ($exercisegroup_to_update2[1]['muscleGroup'] != null && $_POST['ex_group2'] != null) {
              updateExGroup($ex_to_update2['exercise_id'], $_POST['ex_group2'], $exercisegroup_to_update2[1]['muscleGroup']);
            }
            if ($exercisegroup_to_update2[1]['muscleGroup'] == null && $_POST['ex_group2'] != null) { //add
                addExGroup($ex_to_update2['exercise_id'], $_POST['ex_group2']);
            }
            if ($exercisegroup_to_update2[1]['muscleGroup'] != null && $_POST['ex_group2'] == null) { //delete
              deleteExGroup($ex_to_update2['exercise_id'], $exercisegroup_to_update2[1]['muscleGroup']);
            }
            
          }
          if (($k == 2 && $exerciseGroupCount['count(*)'] >= 3) || ($_POST['ex_group3'] != null)) {
            if ($exercisegroup_to_update2[2]['muscleGroup'] != null && $_POST['ex_group3'] != null) {
              updateExGroup($ex_to_update2['exercise_id'], $_POST['ex_group3'], $exercisegroup_to_update2[2]['muscleGroup']);
            }
            if ($exercisegroup_to_update2[2]['muscleGroup'] == null && $_POST['ex_group3'] != null) { //add
              addExGroup($ex_to_update2['exercise_id'], $_POST['ex_group3']);
            }
            if ($exercisegroup_to_update2[2]['muscleGroup'] != null && $_POST['ex_group3'] == null) { //delete
              deleteExGroup($ex_to_update2['exercise_id'], $exercisegroup_to_update2[2]['muscleGroup']);
            }
            
          }
          
          
        }    
        
        
        updateExEntry($_POST['ex_id'], $_POST['date'], $_POST['exercise'], $_POST['calBurned'], $_POST['timeReps']);
        $list_of_entries = getAllExEntries($_SESSION['username'], $_POST['date']);
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
  <h1 style= "vertical-align:middle; text-align:center; font-size: 80px; font-family: 'Courier New', monospace; color:black">Exercise Entries</h1>  

  <form name="mainForm" action="exerciseform.php" method="post">   
    


  <div class="row mb-3 mx-3">
    <input type="hidden" class="form-control" name="ex_id" required 
            value="<?php if ($ex_to_update!=null) echo $ex_to_update['exercise_id'] ?>"
    />        
  </div>

   <div class="row mb-3 mx-3">
   <div style="text-align:center">
   <label>Date:</label>
   <span>
    <input type="date" class="form-control" name="date" required 
            value="<?php if ($ex_to_update!=null) echo $ex_to_update['date'] ?>"
    />
</span>
  </div>
  </div>



  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Exercise:</label>
  <span>
    <input type="text" class="form-control" name="exercise" required 
            value="<?php if ($ex_to_update!=null) echo $ex_to_update['exerciseName'] ?>"
    />
    </span>        
  </div>
  </div>  


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Muscle Group 1:</label>
  <span>
    <input type="text" class="form-control" name="ex_group1"  
            value="<?php if (count($exercisegroup_to_update) > 0) { echo $exercisegroup_to_update[0]['muscleGroup'];
            }
            else {echo "";}?>"
    /> 
    </span>       
  </div>
  </div>


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Muscle Group 2:</label>
  <span>
    <input type="text" class="form-control" name="ex_group2"  
            value="<?php if (count($exercisegroup_to_update) > 0) { echo $exercisegroup_to_update[1]['muscleGroup'];
            }
            else {echo "";}?>"
    />
    </span>        
  </div>
  </div>


  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Muscle Group 3:</label>
  <span>
    <input type="text" class="form-control" name="ex_group3"  
            value="<?php if (count($exercisegroup_to_update) > 0) { echo $exercisegroup_to_update[2]['muscleGroup'];
            }
            else {echo "";}?>"
    />
    </span>        
  </div>
  </div>

  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Calories Burned:</label>
  <span>
    <input type="number" class="form-control" name="calBurned" required 
            value="<?php if ($ex_to_update!=null) echo $ex_to_update['caloriesBurned'] ?>"
    />
    </span> 
  </div>
  </div>  

  <div class="row mb-3 mx-3">
  <div style="text-align:center">
  <label>Time/reps:</label>
  <span>
    <input type="text" class="form-control" name="timeReps" required 
            value="<?php if ($ex_to_update!=null) echo $ex_to_update['time_reps'] ?>"
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



<form action="exerciseform.php" method="post">
<span>
<label >Entries for:  </label>
<input type="date" name="date" value='<?php echo $_SESSION['date']?>' style="width:200px" />
<input type="submit" value="Submit" name="btnAction" class="btn btn-secondary" style="font-size: 12px; width:75px; height:30px;text-align:center" />
</span>
</form>

&nbsp;

<div class="center">
<form action="exerciseform.php" method="post">
<span>
Sort by: 
<input type="submit" value="Default" name="btnAction" class="btn btn-outline-info" style="width:100px" />
    <input type="submit" value="Exercise Name" name="btnAction" class="btn btn-outline-info" style="width:150px" />
    <input type="submit" value="Calories Burned (Ascending)" name="btnAction" class="btn btn-outline-info"  style="width:280px" />
    <input type="submit" value="Calories Burned (Descending)" name="btnAction" class="btn btn-outline-info" style="width:280px" />
</span>
</div>
</form>

&nbsp;

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">        
    <th width="15%">Date</th>        
    <th width="15%">Exercise</th> 
    <th width="5%">Muscle Group</th> 
    <th width="5%"></th>
    <th width="10%"></th>
    <th width="15%">Calories Burned</th> 
    <th width="15%">Time/Reps</th>
    <th width="12%">Update</th>  
    <th width="12%">Delete</th> 
  </tr>
  </thead>
  <?php foreach ($list_of_entries as $entry): ?>
  <tr>
    <?php $count = 0; ?>
    <?php $muscleGroup = getExerciseGroup($entry['exercise_id']) ?>

    <td><?php echo $entry['date']; ?></td>
    <td><?php echo $entry['exerciseName']; ?></td>

    <?php foreach ($muscleGroup as $exEntry): ?>
      <?php $count = $count + 1; ?>
      <td><?php echo $exEntry['muscleGroup']; ?></td>
    <?php endforeach; ?>

    <?php for ($k = $count; $k < 3; $k++) { ?> 
      <td><?php echo ""; ?></td>
    <?php } ?>


    <td><?php echo $entry['caloriesBurned']; ?></td>
    <td><?php echo $entry['time_reps']; ?></td> 
    <td>
      <form action="exerciseform.php" method="post">
        <input type="submit" value="Update" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="ex_to_update" value="<?php echo $entry['exercise_id'] ?>" style="width:80px" />      
      </form>
    </td>
    <td>
    <form action="exerciseform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" />
        <input type="hidden" name="ex_to_delete" value="<?php echo $entry['exercise_id'] ?>" style="width:100px" />      
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