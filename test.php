<?php
include("controllers/config.php");
$download = '';

if(isset($_POST['but_upload'])){
 
  $name = $_FILES['file']['name'];
  $target_dir = "selfies/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);

  // Select file type
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg","jpeg","png","gif");

  // Check extension
  if( in_array($imageFileType,$extensions_arr) ){
 
     // Insert record
     $query = "INSERT INTO user(name, email, pwd, selfie, n_quest, qr_code, status, time) VALUES('', '', '', '$name', '', '', '', '')";
     mysqli_query($db,$query);
  
     // Upload file
     move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
	 
	 $download .= "<a href='".$target_dir.$name."' download>Download Qr-Code</a>";

  }
 
}
?>

<form method="post" action="" enctype='multipart/form-data'>
  <input type='file' name='file' />
  <input type='submit' value='Upload' name='but_upload'>
  <?php echo $download?>
</form>