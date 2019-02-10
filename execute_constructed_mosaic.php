<?php
	
	$fish_path = $_GET['image'];
	$useraddress = $_GET['user'];
	$seshID = session_id();

function output_image($image_file) {
    		header('Content-Length: ' . filesize($image_file));
			// imagejpeg($final,null,$jpeg_quality); //display image to browser window (viewport)
    		ob_clean();
    		flush();
    		readfile($image_file);
		}

	// make filename equivalent to prior naming scheme of input file
		$file = $fish_path;
		$nospace = explode(" ", $file);
		$noslash = explode("/", $nospace[0]);
		$sepgenus = explode("_", $noslash[2]);
		$exportPath = "fish_output/" . $noslash[1] . "/";
		// $name = md5($file) . ".jpg";
		$name = $noslash[1] . "_" . $sepgenus[1] . "_" . $nospace[1];

		// make directory for family output if doesn't already exist
		if(!is_dir($exportPath)) {
			mkdir($exportPath);
		}

		// $image_file = "fish_output/" . $name;
		$image_file = $exportPath . $name;

		$img = $_POST['img'];
   
   	if (strpos($img, 'data:image/png;base64') === 0) {
       
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      // $file = 'uploads/img'.date("YmdHis").'.png';
      $fileName = $image_file;
   
      if (file_put_contents($fileName, $data)) {
         echo "The canvas was saved as $file.";
      } else {
         echo 'The canvas could not be saved.';
      }   
     
   }

		$txt = "_outputData.html";


		$date   = new DateTime();
		$readableDate = $date->format('m-d-Y,h:i:sa');

		if(!file_exists($image_file)) {

   			$fh = fopen($txt, 'a'); 
    		$txt=$file.','. $exportPath . $name . ',' . $seshID . ',' . round($fish_ws) . 'x' . round($fish_hs) . ',(' . round($pos_x) . ',' . round($pos_y) . '),' . $fish_mosaic_w . ',' . $readableDate . ',' . $seshID . ',' . $useraddress . '<hr />'; 
    		fwrite($fh,$txt); // Write information to the file
    		fclose($fh); // Close the file

		} else {
			$fh = fopen($txt, 'a'); 
    		$txt=$file.','. $exportPath . $name . ', REDO ,' . $seshID . ',' . round($fish_ws) . 'x' . round($fish_hs) . ',(' . round($pos_x) . ',' . round($pos_y) . '),' . $fish_mosaic_w . ',' . $readableDate . ',' . $seshID . ',' . $useraddress . '<hr />'; 
    		fwrite($fh,$txt); // Write information to the file
    		fclose($fh); // Close the file
		}

/*

	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	echo $fileData;

	// $parts = explode(',', $dataURL); 
    // $data = base64_decode($parts[1]);

	//saving
	// $fileName = 'photo.png';
	$fileName = $image_file;
	file_put_contents($fileName, $data);

	output_image($image_file);*/


?>