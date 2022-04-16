<?php
//session_start();

function addFoodEntry($food_id, $date, $food, $calories, $timeEaten) #add parameter for username
{
	global $db;

	$query = "insert into foodEntry values(:food_id, :date, :food, :calories, :timeEaten)";

	$statement = $db->prepare($query);

	$statement->bindValue(':food_id', $food_id);
	$statement->bindValue(':date', $date);
	$statement->bindValue(':food', $food);
	$statement->bindValue(':calories', $calories);
	$statement->bindValue(':timeEaten', $timeEaten);

	$statement->execute();
	$statement->closeCursor();
}

function addFoodCreateEntry($food_id, $username) #add parameter for username
{
	global $db;

	$query = "insert into createFood values(:food_id, :username)";

	$statement = $db->prepare($query);

	$statement->bindValue(':food_id', $food_id);
	$statement->bindValue(':username', $username);

	$statement->execute();
	$statement->closeCursor();
}



function addExEntry($ex_id, $date, $exercise, $calBurned, $timeReps) #add parameter for username
{
	global $db;

	$query = "insert into exerciseEntry values(:ex_id, :date, :exercise, :calBurned, :timeReps)";

	$statement = $db->prepare($query);

	$statement->bindValue(':ex_id', $ex_id);
	$statement->bindValue(':date', $date);
	$statement->bindValue(':exercise', $exercise);
	$statement->bindValue(':calBurned', $calBurned);
	$statement->bindValue(':timeReps', $timeReps);

	$statement->execute();
	$statement->closeCursor();
}

function addExCreateEntry($ex_id, $username) #add parameter for username
{
	global $db;

	$query = "insert into createExercise values(:ex_id, :username)";

	$statement = $db->prepare($query);

	$statement->bindValue(':ex_id', $ex_id);
	$statement->bindValue(':username', $username);


	$statement->execute();
	$statement->closeCursor();
}


function addSleepEntry($sleep_id, $date, $hoursSlept) 
{
	global $db;

	$query = "insert into sleepEntry values(:sleep_id, :date, :hoursSlept)";

	$statement = $db->prepare($query);

	$statement->bindValue(':sleep_id', $sleep_id);
	$statement->bindValue(':date', $date);
	$statement->bindValue(':hoursSlept', $hoursSlept);
	

	$statement->execute();
	$statement->closeCursor();
}



function addSleepCreateEntry($sleep_id, $username) #add parameter for username
{
	global $db;

	$query = "insert into createSleep values(:sleep_id, :username)";

	$statement = $db->prepare($query);

	$statement->bindValue(':sleep_id', $sleep_id);
	$statement->bindValue(':username', $username);


	$statement->execute();
	$statement->closeCursor();
}








function getAllEntries($username, $date)
{
	global $db;
	$query = "select * from foodEntry natural join createfood where username=:username AND date=:date";

// bad	
	// $statement = $db->query($query);     // 16-Mar, stopped here, still need to fetch and return the result 
	
// good: use a prepared stement 
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}


function getAllExEntries($username, $date)
{
	global $db;
	$query = "select * from exerciseEntry natural join createExercise where username=:username AND date=:date";


	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}


function getAllSleepEntries($username)
{
	global $db;
	$query = "select * from sleepEntry natural join createSleep where username=:username";


	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}



function getFood_byID($food_id)
{
	global $db;
	$query = "select * from foodEntry where food_id = :food_id";
	
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}


function getEx_byID($ex_id)
{
	global $db;
	$query = "select * from exerciseEntry where exercise_id = :ex_id";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->execute();

	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}

function getSleep_byID($sleep_id)
{
	global $db;
	$query = "select * from sleepEntry where sleep_id = :sleep_id";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':sleep_id', $sleep_id);
	$statement->execute();

	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}


function getRating_byID($rating_id)
{
	global $db;
	$query = "select * from rating where rating_id = :rating_id";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':rating_id', $rating_id);
	$statement->execute();

	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}




function updateEntry($food_id, $date, $food, $calories, $timeEaten)
{
	global $db;
	$query = "update foodEntry set foodName=:food, calories=:calories, timeEaten=:timeEaten, date=:date where food_id=:food_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->bindValue(':date', $date);
	$statement->bindValue(':food', $food);
	$statement->bindValue(':calories', $calories);
	$statement->bindValue(':timeEaten', $timeEaten);
	$statement->execute();
	$statement->closeCursor();
}

function updateExEntry($ex_id, $date, $exercise, $calBurned, $timeReps)
{
	global $db;
	$query = "update exerciseEntry set exerciseName=:exercise, caloriesBurned=:calBurned, time_reps=:timeReps, date=:date where exercise_id=:ex_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->bindValue(':date', $date);
	$statement->bindValue(':exercise', $exercise);
	$statement->bindValue(':calBurned', $calBurned);
	$statement->bindValue(':timeReps', $timeReps);
	$statement->execute();
	$statement->closeCursor();
}

function updateSleepEntry($sleep_id, $date, $hoursSlept)
{
	global $db;
	$query = "update sleepEntry set hoursSlept=:hoursSlept, date=:date where sleep_id=:sleep_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':sleep_id', $sleep_id);
	$statement->bindValue(':date', $date);
	$statement->bindValue(':hoursSlept', $hoursSlept);
	$statement->execute();
	$statement->closeCursor();
}


function updateRating($rating_id, $value) {
	global $db;
	$query = "update rating set value=:value where rating_id=:rating_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':rating_id', $rating_id);
	$statement->bindValue(':value', $value);
	$statement->execute();
	$statement->closeCursor(); 
}

function updateMake($rating_id, $username) {
	global $db;
	$query = "update make set username=:username, rating_id=:rating_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':rating_id', $rating_id);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$statement->closeCursor(); 
}


function deleteEntry($food_id) {
	global $db;
	$query = "delete from foodEntry where food_id=:food_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->execute();
	$statement->closeCursor();


}

function deleteCreateEntry($food_id) {
	global $db;
	$query = "delete from createFood where food_id=:food_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->execute();
	$statement->closeCursor();
}

function deleteExEntry($ex_id) {
	global $db;
	$query = "delete from exerciseEntry where exercise_id=:ex_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->execute();
	$statement->closeCursor();


}

function deleteCreateExEntry($ex_id) {
	global $db;
	$query = "delete from createExercise where exercise_id=:ex_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->execute();
	$statement->closeCursor();
}


function deleteSleepEntry($sleep_id) {
	global $db;
	$query = "delete from sleepEntry where sleep_id=:sleep_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':sleep_id', $sleep_id);
	$statement->execute();
	$statement->closeCursor();
}

function deleteCreateSleepEntry($sleep_id) {
	global $db;
	$query = "delete from createSleep where sleep_id=:sleep_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':sleep_id', $sleep_id);
	$statement->execute();
	$statement->closeCursor();
}




function getUser($username) {
	global $db;
	$query = "Select username from User where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();  
	return $results;

}

function getPass($username) {
	global $db;
	$query = "Select password from User where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();  
	return $results;

}

function findUser($username) {
	global $db;
	$query = "Select * from User where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();  
	return $results;
}

function insertUser($username, $password, $name) {
	global $db;
	$query = "insert into User values (:username, :password, :name, 0, 0, 0)";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':password', $password);
	$statement->bindValue(':name', $name);
	$statement->execute();
	$statement->closeCursor();  
}


function updateInfo($username, $maxcal, $maxsleep) { //CURRENTLY UNUSED
	global $db;
	$query = "update User set daily_calorie_intake=:maxcal, daily_sleep_time=:maxsleep where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':maxcal', $maxcal);
	$statement->bindValue(':maxsleep', $maxsleep);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();  
	return $results;
}

function nextFoodID() {
	global $db;
	$query = "select max(food_id) from FoodEntry";
	$statement = $db->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();  
	return $results;
}


function insertRating($rating_id, $value) {
	global $db;
	$query = "insert into rating values (:rating_id, :value)";
	$statement = $db->prepare($query);
	$statement->bindValue(':rating_id', $rating_id);
	$statement->bindValue(':value', $value);
	$statement->execute();
	$statement->closeCursor();  
}

function getRating($username) {
	global $db;
	$query = "select * from rating natural join make where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();  
	return $results;
}

function insertMake($rating_id, $username) {
	global $db;
	$query = "insert into make values (:username, :rating_id)";
	$statement = $db->prepare($query);
	$statement->bindValue(':rating_id', $rating_id);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$statement->closeCursor(); 
}


function checkRatingExists($username) {
	global $db;
	$query = "select count(*) from make where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}


function getAverageRating() {
	global $db;
	$query = "select AVG(value) from rating";
	$statement = $db->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}


function getCalorie($username) {
	global $db;
	$query = "select daily_calorie_intake from User where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}

function getSleep($username) {
	global $db;
	$query = "select daily_sleep_time from User where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}


function updateCalorie($daily_calorie_intake, $username) {
	global $db;
	$query = "update User set daily_calorie_intake=:daily_calorie_intake where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':daily_calorie_intake', $daily_calorie_intake);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}

function updateSleep($daily_sleep_time, $username) {
	global $db;
	$query = "update User set daily_sleep_time=:daily_sleep_time where username=:username";
	$statement = $db->prepare($query);
	$statement->bindValue(':daily_sleep_time', $daily_sleep_time);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}


function getFoodGroup($food_id) {
	global $db;
	$query = "select * from foodEntry_foodGroup where food_id=:food_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->execute();
	$results = $statement->fetchAll();
	$statement->closeCursor(); 
	return $results;
}

function getExerciseGroup($ex_id) {
	global $db;
	$query = "select * from exerciseEntry_exerciseGroup where exercise_id=:ex_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->execute();
	$results = $statement->fetchAll();
	$statement->closeCursor(); 
	return $results;
}

function getFoodGroupCount($food_id) {
	global $db;
	$query = "select count(*) from foodEntry_foodGroup where food_id=:food_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}

function getExerciseGroupCount($ex_id) {
	global $db;
	$query = "select count(*) from exerciseEntry_exerciseGroup where exercise_id=:ex_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor(); 
	return $results;
}


function addFoodGroup($food_id, $foodGroup) {
	global $db;
	$query = "insert into foodEntry_foodGroup values(:food_id, :foodGroup)";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->bindValue(':foodGroup', $foodGroup);
	$statement->execute();
	$statement->closeCursor(); 
}

function addExGroup($ex_id, $muscleGroup) {
	global $db;
	$query = "insert into exerciseEntry_exerciseGroup values(:ex_id, :muscleGroup)";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->bindValue(':muscleGroup', $muscleGroup);
	$statement->execute();
	$statement->closeCursor(); 
}

function deleteFoodGroups($food_id) {
	global $db;
	$query = "delete from foodEntry_foodGroup where food_id=:food_id";;
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->execute();
	$statement->closeCursor(); 
}

function deleteExerciseGroups($ex_id) {
	global $db;
	$query = "delete from exerciseEntry_exerciseGroup where exercise_id=:ex_id";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->execute();
	$statement->closeCursor(); 
}

function deleteFoodGroup($food_id, $foodGroup) {
	global $db;
	$query = "delete from foodEntry_foodGroup where food_id=:food_id AND foodGroup=:foodGroup";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->bindValue(':foodGroup', $foodGroup);
	$statement->execute();
	$statement->closeCursor(); 
}


function deleteExGroup($ex_id, $muscleGroup) {
	global $db;
	$query = "delete from exerciseEntry_exerciseGroup where exercise_id=:ex_id AND muscleGroup=:muscleGroup";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->bindValue(':muscleGroup', $muscleGroup);
	$statement->execute();
	$statement->closeCursor(); 
}

function updateFoodGroup($food_id, $foodGroup, $oldValue)
{
	global $db;
	$query = "update foodEntry_foodGroup set foodGroup=:foodGroup where food_id=:food_id AND foodGroup=:oldValue";
	$statement = $db->prepare($query);
	$statement->bindValue(':food_id', $food_id);
	$statement->bindValue(':foodGroup', $foodGroup);
	$statement->bindValue(':oldValue', $oldValue);
	$statement->execute();
	$statement->closeCursor();
}

function updateExGroup($ex_id, $muscleGroup, $oldValue)
{
	global $db;
	$query = "update exerciseEntry_exerciseGroup set muscleGroup=:muscleGroup where exercise_id=:ex_id AND muscleGroup=:oldValue";
	$statement = $db->prepare($query);
	$statement->bindValue(':ex_id', $ex_id);
	$statement->bindValue(':muscleGroup', $muscleGroup);
	$statement->bindValue(':oldValue', $oldValue);
	$statement->execute();
	$statement->closeCursor();
}


function getMaxFoodID()
{
	global $db;
	$query = "select MAX(food_id) from foodEntry";
	$statement = $db->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function getMaxExID()
{
	global $db;
	$query = "select MAX(exercise_id) from exerciseEntry";
	$statement = $db->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function getMaxSleepID()
{
	global $db;
	$query = "select MAX(sleep_id) from sleepEntry";
	$statement = $db->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function getMaxRatingID()
{
	global $db;
	$query = "select MAX(rating_id) from rating";
	$statement = $db->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}

function sortExerciseName($username, $date)
{
	global $db;
	$query = "select * from exerciseEntry natural join createExercise where username=:username AND date=:date order by exerciseName";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function sortExerciseCalAsc($username, $date)
{
	global $db;
	$query = "select * from exerciseEntry natural join createExercise where username=:username AND date=:date order by caloriesBurned";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function sortExerciseCalDesc($username, $date)
{
	global $db;
	$query = "select * from exerciseEntry natural join createExercise where username=:username AND date=:date order by caloriesBurned DESC";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}


function sortFoodName($username, $date)
{
	global $db;
	$query = "select * from foodEntry natural join createFood where username=:username AND date=:date order by foodName";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}


function sortFoodCalAsc($username, $date)
{
	global $db;
	$query = "select * from foodEntry natural join createFood where username=:username AND date=:date order by calories";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}


function sortFoodCalDesc($username, $date)
{
	global $db;
	$query = "select * from foodEntry natural join createFood where username=:username AND date=:date order by calories DESC";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}


function sortSleepAsc($username)
{
	global $db;
	$query = "select * from sleepEntry natural join createSleep where username=:username order by hoursSlept";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}



function sortSleepDesc($username)
{
	global $db;
	$query = "select * from sleepEntry natural join createSleep where username=:username order by hoursSlept DESC";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function getActualCalorie($username, $date)
{
	global $db;
	$query = "select SUM(calories) from foodEntry natural join createFood where username=:username AND date=:date";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':date', $date);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	return $results;
}


function checkRating() {
	global $db;
	$query = "ALTER TABLE rating ADD CONSTRAINT checkRating CHECK (value >= 0)";
	$statement = $db->prepare($query);
	$statement->execute();
	$statement->closeCursor();
}


function checkSleep() {
	global $db;
	$query = "ALTER TABLE sleepEntry ADD CONSTRAINT checkSleep CHECK (hoursSlept <= 24)";
	$statement = $db->prepare($query);
	$statement->execute();
	$statement->closeCursor();
}


















?>