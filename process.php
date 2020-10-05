<?php 
// connect to the database
include('controllers/config.php');

$fileTypeError = '';
$error = '';
$success = "";
// REGISTER USER
if ($db) {
	echo "Connected to DB";
}else{
	echo "Error Connecting". mysqli_error;
}
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pwd']) && isset($_FILES['selfie'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $pwd = mysqli_real_escape_string($db, $_POST['pwd']);
  $n_quest = mysqli_real_escape_string($db, $_POST['n_quest']);
  
  $selfie = $_FILES['selfie']['name'];
  $target_dir = 'selfies/';
  $filename = $target_dir.basename($_FILES['selfie']['name']);
  
  // Select File type
  $selfieFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  
  // Valid File Extensions
  $extensions_arr = array("jpg", "jpeg", "png", 'JPEG', "JPG");
  	  
	/* $query_user = "SELECT * FROM user WHERE email=$email";
	$result = mysqli_query($db, $query_user);
	if (mysqli_num_rows($result) > 0)  {
	  
	  $error += "User already registered!";
	  echo $error;
	}
	   */
	  
	    // Check Extensions
	if(in_array($selfieFileType, $extensions_arr)){
	  
	  // Insert into db
	  $run_query = mysqli_query($db, "INSERT INTO user(name, email, pwd, selfie, n_quest, qr_code, status, time) VALUES('$name', '$email', '$pwd', '$selfie', '$n_quest', '', '', '')");
	  if ($run_query){
		// move image to selfie/ folder in server
		move_uploaded_file($_FILES['selfie']['tmp_name'], $target_dir.$name);
	  
		$success += "Congratulations, Your registration was successful, go ahead and download your QR Code";
		echo $success;  
	  }else {
		  echo "Error occured". mysqli_error;
	  }
	  
	}else{
		$fileTypeError += "Invalid File Type. Selfie must be in (JPEG, JPG, PNG) format";
		echo $fileTypeError;
	}
  
}

?>
