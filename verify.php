<?php
include('controllers/config.php');
if (isset($_GET['n'])){
	$salt = $_GET['n'];
	
	$query_user = "SELECT * FROM user WHERE salt='$salt' ";
		$result = mysqli_query($db, $query_user);
		$fetch = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) <= 0){
			echo "<h1 style='font-size: 100px; color: red;'>SORRY, YOU'RE NOT INVITED FOR THIS GATHERING<h1>";
		}else{
			
			
		
		
		$name = $fetch['name'];
		$email = $fetch['email'];
		$qr_code = $fetch['qr_code'];
		$n_quest = $fetch['n_quest'];
		$selfie = $fetch['selfie'];
		

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
	   //background-color: black;
   }
   .content{
	   width: 70%;
	   max-height: 70%;
	   margin: 0 auto;
	   margin-top: 10%;
	   margin-bottom: 3%;
	   border: solid 3px #007bff;
	   background-color: #007bff;
	   border-radius: 8px;
   }
   .img{
	   width: 250px !important;
	   height: auto !important;
	   max-height 200px;
	   border: solid 5px #dddddd;
	   border-radius: 70px 0px 70px 0px;
   }
   .v{
	   width: 200px;
	   height: auto;
	  
   }
   .img-wrap{
	   background-color: white;
	   margin: 0px !important;
	   padding: 30px !important;
   }
   .my_text{
	   padding: 10px !important;
	   text-align: center;
   }
   .container{
	   padding:0px !important;
   }
  </style>
</head>
<body>

  
<div class="container" >
	<div class="content row">
		<div class="col-sm-6 img-wrap">
			<img class="img img-fluid  mx-auto d-block" src="<?php echo "selfies/".$fetch['selfie']?>" />
			<img class="v mx-auto d-block" src="img/v.png" />
		</div>
		<div class="col-sm-6 my_text">
			<h3 style="color: white">Hurray!! </h3>
			<h2 style="color: white">You're Live 4 the Party</h2> <br>
			<h1 style="color: #320c3a">Welcome, <b><?php echo $name;?></b></h1> 			
			<p>Email: <b><?php echo $email;?></b></p>
			<p>No. of Quest: <b><?php echo $n_quest;?></b></p>
		</div>
		
	</div>
</div>


</body>
</html>
<?php }} ?>

	
	

