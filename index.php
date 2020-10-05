<?php 
// connect to the database
include('controllers/config.php');
require_once 'phpqrcode/qrlib.php';

$qr_path = 'qrcodes/';
$qr_code = $qr_path.uniqid().".png";
$v_url = "http://localhost/e-attendance/verify.php?n=";
$salt = time();


$fileTypeError = '';
$error = '';
$login_error = '';
$success = "";
$download = '';

// REGISTER USER
if (isset($_POST['reg']) && isset($_FILES['selfie']['name'])) {
	if(!empty($_POST['name']) &&  (!empty($_POST['email'])) && (!empty($_POST['pwd'])) && (!empty($_FILES['selfie']))){
		// receive all input values from the form
	  $name = mysqli_real_escape_string($db, $_POST['name']);
	  $email = mysqli_real_escape_string($db, $_POST['email']);
	  $pwd = mysqli_real_escape_string($db, $_POST['pwd']);
	  $pwd = md5($pwd);
	  $n_quest = mysqli_real_escape_string($db, $_POST['n_quest']);
	  $v_url .= $salt;
	  
	  $selfie = $_FILES['selfie']['name'];
	  $target_dir = 'selfies/';
	  $filename = $target_dir.basename($_FILES['selfie']['name']);
	  
	  // Select File type
	  $selfieFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));;
	  
	  // Valid File Extensions
	  $extensions_arr = array("jpg", "jpeg", "png", 'JPEG', "JPG");
		  
		$query_user = "SELECT email FROM user WHERE email='$email' ";
		$result = mysqli_query($db, $query_user);
		$fetch = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) > 0) {
		  
		  $error .= "User already registered!";
		  
		}
		  
		  
			// Check Extensions
		if(in_array($selfieFileType, $extensions_arr)){
		  
			  // Insert into db
			$query = "INSERT INTO user(name, email, pwd, selfie, n_quest, qr_code, status, salt) VALUES('$name', '$email', '$pwd', '$selfie', '$n_quest', '$qr_code', '', '$salt')";
			if (mysqli_query($db, $query)){
				// move image to selfie/ folder in server
				move_uploaded_file($_FILES['selfie']['tmp_name'], $target_dir.$selfie);
			  
				// Generate and move QR-CODE into qrcodes/ folder in server.
				QRcode::png($v_url, $qr_code, 'L', 10, 2);
				
				$success .= "Congrats! ".$name.", Your registration was successful, go ahead and download your QR Code";
				
			}
			  
		}else{
			$fileTypeError = "Invalid File Type. Selfie must be in (JPEG, JPG, PNG) format";
			
		}
	}
  
  
}

// Download QR Code
if (isset($_POST['download_qr']) && (!empty($_POST['email'])) && (!empty($_POST['pwd']))){
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	$pwd = md5($pwd);
	$query_user = "SELECT * FROM user WHERE email='$email' AND pwd='$pwd'";
	$result = mysqli_query($db, $query_user);
	$fetch = mysqli_fetch_assoc($result);
	
	if (mysqli_num_rows($result) > 0) {
		$filename = $fetch['qr_code'];
		$download .= "<a class='btn btn-primary btn-success btn-lg' href='".$filename."' download>DOWNLOAD QR-CODE</a>";
		$success .= "Account Verified, Click the button Below to down QR-CODE";
		  
	}else{
		$login_error .= "Account Not Found, Try again";
	}
		  
	
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>E-Identity Verification</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <style>
	body{
		background-color:#f0f4f7;
	}
    .banner{
      }
    .cbanner{
      padding: 0px;
    }
    h3{
      text-align: center;
      color: #cb5f93;
	  font-family: Inter,-apple-system,BlinkMacSystemFont,Segoe UI,Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
	  font-weight: bold;
    }
    .rbox{
      background-color:white;
      border-radius: 10px;
      padding: 20px;
      max-height: 85%;
	  box-shadow: 0 5px 10px rgba(154,160,185,.05), 0 15px 40px rgba(166,173,201,.2);
    }
	.form-control{
		border: solid 1px rgb(195, 195, 195);
	}
	.login_page{
		background-color: #f0f4f7;
	}
  </style>
</head>
<body>

  
<div class="container-fluid" >
	<div class="row" >
    <div class="col-sm-6 cbanner">
        <img class="banner img-fluid" src="img/banner.JPEG" alt="banner">
      
    </div>

    <div class="col-sm-6 login_page">
        <br>
        <h3 class"heading">E-IDENTITY VERIFICATION SYSTEM</h3>
        <p class="text-center text-info">Register / Download QR Code below</p>
		<br>
		<p class="text-success text-center text-bold"><?php echo $success?></p>
		<p class="text-danger text-center text-bold"><?php echo $login_error?></p>
		<p class="text-center"><?php echo $download ?></p>
        

      <div class="container rbox">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#register">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#download">QR Download</a>
          </li>
        
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
		<form method="GET" action="verify.php">
			<input type="hidden" name="n" />
		</form>
          <div id="register" class="container tab-pane active"><br>
            <form action="" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Fullname" name="name" required>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required>
                <div class="invalid-feedback">Please fill out this field.</div>
				<p class="text-danger"><?php echo $error?></p>
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
              <div class="form-group">
                <label for="selfie">Upload a Selfie:</label>
                <input type="file" class="form-control" id="selfie" name="selfie" required>
                <div class="invalid-feedback">Upload a valid Photograph</div>
				<p class="text-danger"><?php echo $fileTypeError?></p>
              </div>
              <div class="form-group">
                <label for="n_quest">Number of Quests(Optional):</label>
                <input type="number" class="form-control" id="n_quest" placeholder="optional" name="n_quest" >
				<div class="invalid-feedback">Must be numbers</div>
              </div>
			  
              <input type="submit" class="btn btn-primary" name="reg" value="REGISTER">
            </form>
          </div>

		<div id="download" class="container tab-pane fade"><br>
            <form action="#download" method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                
                <input type="submit" class="btn btn-primary" name="download_qr" value= "VERIFY USER">
            </form>
          
          </div>
          
		  
		  
		  
		  </div>
		  
                  
        </div>
		
		<p class="text-center text-info" style="margin: 15px 0;">Built with Love By <a href="https://wwww.facebook.com/wisdom.uzochukwu.10">Aturuobi U. A<a/> | techcrest.com.ng </p>

      
      </div>
      
    </div>
  </div>

</div>

<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>	
</body>
</html>
