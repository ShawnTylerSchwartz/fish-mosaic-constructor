<?php 
	session_start();

	$user_email = $_GET['user'];

	include 'snippets/header.php';
	include 'snippets/main.php';

	$img_path = $_GET['image'];

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



<h2>Constructed Fish Mosaic:</h2>
<div id="img-out" style="background-color: transparent; width: 375px;"></div>

<div class="constructed-fish-container" id="constructed-fish-container" style="background-color: transparent; width: 375px; height: 250px;">
	<?php
		list($width, $height, $type, $attr) = getimagesize("fish_output/1_" . $noslash[1] . "/" . $name);

//width: 450px; 
		$resize_factor_for_eye_slots = $width / 2;

		echo "<div style='padding-bottom: 83px;'></div>";
		echo "<img src='fish_output/7_" . $noslash[1] . "/" . $name . "' style='position: relative; top: 7.5px; width: " . $resize_factor_for_eye_slots . "px; height: " . $resize_factor_for_eye_slots . "px;' />";
		echo "<br />";
		echo "<img src='fish_output/8_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -9.5px; width: " . $resize_factor_for_eye_slots . "px; height: " . $resize_factor_for_eye_slots . "px;' />"; 
		echo "<img src='fish_output/1_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -27px;' />";
		echo "<img src='fish_output/2_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -27px;' />";
		echo "<img src='fish_output/3_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -27px;' />";
		echo "<img src='fish_output/4_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -27px;' />";
		/*echo "<img src='fish_output/5_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -96px; left: -138px;' />";
		echo "<img src='fish_output/6_" . $noslash[1] . "/" . $name . "' style='position: relative; top: 42px; left: -207px;' />";*/
		echo "<img src='fish_output/5_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -165px; left: 172px;' />";
		echo "<img src='fish_output/6_" . $noslash[1] . "/" . $name . "' style='position: relative; top: -27px; left: 103px;' />";
	?>
</div>
<button id="savemosaicbutton">Save fish</button>
	<script>

	mosaicoutput = document.getElementById('constructed-fish-container');

	// var canvas = document.getElementById("constructed-fish-container");
	//var ctx = c.getContext('2d');
  					//ctx.fillStyle = "#f47742";
  					// ctx.fillStyle = 'rgba(255, 0, 0, 0.5)';
  	//ctx.globalAlpha = 0.2;
  	//ctx.fillRect(0, 0, 450, 250);

  	var dataURL;

	html2canvas($('#constructed-fish-container')[0], {
  					scale:1
				}).then(function(canvas) {

  					//ctx.beginPath();
  					//var shifted_horclickone_x = (Hor_ClickOne_x - 12);
  					//console.log(shifted_horclickone_x);
    				//ctx.arc(shifted_horclickone_x, Hor_ClickOne_y, 2, 0, Math.PI * 2, true);
    				// ctx.fill();

  					$("#img-out").append(canvas);
  					mosaicoutput.style.display = 'none';
  					dataURL = canvas.toDataURL();
  					console.log(dataURL);
	});

				var tmp_img_holder = "<?php echo $img_path; ?>";
				var tmp_user_email = "<?php echo $user_email; ?>";
				var tmp_sid = "<?php echo SID; ?>";
				console.log("TMP SID: " + tmp_sid);

	$("#savemosaicbutton").click(function(e) {
		e.preventDefault();

		$.ajax({
				type: "POST",
				url: "execute_constructed_mosaic.php?image="+tmp_img_holder+"&user="+tmp_user_email+"&"+tmp_sid,
				data: { 
					img: dataURL
				},
		        success: function(result) {
		            alert('ok');
		        },
		        error: function(result) {
		            alert('error');
		        }

		}).done(function(o) {
				console.log('saved'); 
		});
	});

	</script>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	

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