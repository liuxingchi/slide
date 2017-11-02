<?php
if ($_FILES["btn"]["error"] > 0)
{
	echo "Return Code: " . $_FILES["btn"]["error"] . "<br />";
}
else
{
	$new_filename = time().substr($_FILES["btn"]["name"],-4);
	move_uploaded_file($_FILES["btn"]["tmp_name"],"upload/" . $new_filename);
	$array = array(
			'filename'=>$new_filename,
	);
	echo json_encode($array);
		
}
