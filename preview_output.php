<?php 
	session_start();

	$user_email = $_GET['user'];

	include 'snippets/header.php';
	include 'snippets/main.php';

	$img_path = $_GET['img'];

	$nospace = explode(" ", $img_path);
		$noslash = explode("/", $nospace[0]);
		$sepgenus = explode("_", $noslash[2]);
		
		// $name = md5($file) . ".jpg";
		$name = $noslash[1] . "_" . $sepgenus[1] . "_" . $nospace[1];

	echo "<h2>Are you satisified with the output?</h2>";
	echo "<p class='lead'>Note: If a <em>sampling mosaic square</em> has any part of the background (spill-over) that is not a part of the fish, please try again. If you are unable to sample the fish without the background, please click <strong>at the bottom of the page</strong> to note this fish in the system for <u>further review</u>.</p>";
	echo "<a href='fish_list.php?user=" . $user_email . '&' . SID . "' class='btn btn-success'>Yes, next fish <i class='fas fa-forward'></i></a>";
	echo "&nbsp; &nbsp;";
	echo "<a href='scale_fish.php?image=" . $img_path . '&user=' . $user_email . '&' . SID . "' class='btn btn-danger'>No, redo <i class='fas fa-undo'></i></a>";
	echo "<br /><br />";

	$descriptions = array();

	$descriptions[0] = "(Anterior margin of gill slit)";
	$descriptions[1] = "(Posterior margin of gill slit)";
	$descriptions[2] = "(Midpoint along SL)";
	$descriptions[3] = "(Caudal peduncle posterior margin)";
	$descriptions[4] = "(Dorsal point of fish depth)";
	$descriptions[5] = "(Ventral point of fish depth)";
	$descriptions[6] = "(Posterior point of fish eye)";
	$descriptions[7] = "(Ventral point of fish eye)";

	for ($i = 1; $i <= 8; $i++)
	{
		echo "<strong>Sampling Square " . $i . ":</strong> ";
		$exportPath = "fish_output/" . $i . "_" . $noslash[1] . "/";
		echo "<img src='" . $exportPath . $name . "' />";
		echo " " . $descriptions[$i-1];
		echo "<br /><br />";
	}
?>

	<form action="" method="post">
		<button type="submit" class="btn btn-warning"><i class="fas fa-exclamation-triangle"></i> Report Fish</button>
		<input type="hidden" name="button_pressed" value="1" />
	</form>

<?php
	if(isset($_POST['button_pressed']))
	{
	    $to      = 'shawnschwartz@ucla.edu';
	    $subject = 'MOSAIC FISH ISSUE';
	    $message = 'Issue with fish: ' . $img_path . ' output located at: ' . $exportPath . $name;
	    $headers = 'From: fish-mosaic@shawntylerschwartz.com' . "\r\n" .
	        'Reply-To: shawnschwartz@ucla.edu' . "\r\n" .
	        'X-Mailer: PHP/' . phpversion();

	    mail($to, $subject, $message, $headers);

	    echo 'Fish successfully reported. It will be reviewed. Please continue on with another fish in the meantime. Thank you!';
	}
?>