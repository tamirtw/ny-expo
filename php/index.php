<?php

$msg = '';

$project = 0;
$projectName = $_REQUEST['p'];


function projectIdForName($name)
{
	switch ($name) {
		case 'ngui': 	return 1;
		case 'dciti': 	return 2;
		case 'cvm': 	return 3;
		case 'cr': 		return 4;
		case 'qi': 		return 5;
		default: return 0;
	}
	return 0;
}

if($_POST['email']){
	
	// Requested with AJAX:
	$ajax = ($_SERVER['HTTP_X_REQUESTED_WITH']  == 'XMLHttpRequest');
	
	try{
		if(!filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)){
			throw new Exception('Invalid Email!');
		}
		$db = new PDO('sqlite:' . getenv('OPENSHIFT_DATA_DIR') . 'leads.sqlite');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO leads (email,project) VALUES (?,?)";
		$email = $_POST['email'];
		$q = $db->prepare($sql);
		$success = $q->execute(array($email,projectIdForName($projectName)));


		if(!$success){
			throw new Exception('This email already exists in the database.');
		}
		
		if($ajax){
			die('{"status":1}');
		}
		
		$msg = "Thank you!";
		
	}
	catch (Exception $e){
		
		if($ajax){
			die(json_encode(array('error'=>$e->getMessage(),
				'path'=>'sqlite:' . getenv('OPENSHIFT_DATA_DIR') . 'leads.sqlite')));
		}
		
		$msg = $e->getMessage();		
	}
}
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Citi Innovation Lab Tlv at NY Citi Expo</title>

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="css/nivo-slider.css" />

</head>

<body>

<div id="page">

    <h1><? echo $_GET['p'] ?></h1>
    
    <div id="slideshowContainer">
        <div id="slideshow">
            <img src="img/slides/slide_<?=projectIdForName($projectName)?>_1.jpg" width="454" height="169" alt="">
            <img src="img/slides/slide_<?=projectIdForName($projectName)?>_2.jpg" width="454" height="169" alt="">
            <img src="img/slides/slide_<?=projectIdForName($projectName)?>_3.jpg" width="454" height="169" alt="">
        </div>
	</div>
        
    <h2>Subscribe</h2>
    
    <form method="post" action="">
    	<input type="text" id="email" name="email" value="<?php echo $msg?>" />
        <input type="submit" value="Submit" id="submitButton" />
    </form>
    
</div>

<!-- Feel free to remove this footer -->

<div id="footer">
	<div class="tri"></div>
	<h1>Citi Innovation Lab Tlv at NY Citi Expo</h1>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script src="js/jquery.nivo.slider.pack.js"></script>
<script src="js/script.js"></script>

</body>
</html>
