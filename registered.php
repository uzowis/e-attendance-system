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
	   background-color: ;
   }
   .jumbotron{
	   background-color: #0f0b2c !important;
	   color: #009cfa;
   }
   .jb{
	   color: white;
   }
   .img{
	   width: 50px;
	   height: auto;
   }
   
   
  </style>
</head>
<body>

 <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="text-center ">REGISTERED ATTENDEES</h1> <br>     
    <p class="text-center jb">Below is the List of Registered attendees for the forth-coming Ex Montessorian Re-Union Party</p>
  </div>
</div>

<div class="container">
  
  <table class="table table-responsive-md">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Photograph</th>
        <th>QR-CODE</th>
        <th>Attendee's Name</th>
        <th>Email</th>
        <th>Quests</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
	
	<?php 
	include('controllers/config.php');
	$query = "SELECT * FROM user";
	$run = mysqli_query($db, $query);
	$id = 0;
	while($result = mysqli_fetch_assoc($run)){
		
		if (mysqli_num_rows($run) > 0){
			
		 
	?>
      <tr>
        <td><?php echo $id +=1;?></td>
		<td><img class="img img-fluid  mx-auto d-block" src="<?php echo "selfies/".$result['selfie']?>" /></td>
		<td><img class="img   mx-auto d-block" src="<?php echo $result['qr_code']?>" /></td>
        <td><?php echo $result['name']?></td>
        <td><?php echo $result['email']?></td>
        <td><?php echo $result['n_quest']?></td>
        <td><span class="badge badge-success">Registered</span></td>
      </tr>
	<?php }}?>
    </tbody>
  </table>



</body>
</html>