<?php
session_start();
require('include/config.php');
require('functions.php');
validate_access();
?>
<?php
if (!isset($_GET['id'])) {
	echo "You have not chosen an Image. So you won't be able to use categorize option.";
}
if(isset($_POST["btnSubmit"])) {
	$errors = array();
	$uploadedFiles = array();
	$extension = array("jpeg","jpg","png","gif","bmp");
	$bytes = 1024;
	$KB = 1024;
	$totalBytes = 50 * ($bytes * $KB);
	$UploadFolder = "UploadFolder";
	$counter = 0;

	foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
		$temp = $_FILES["files"]["tmp_name"][$key];
		$name = $_FILES["files"]["name"][$key];
		$datetime = date('Y-m-d h:i:s');
		$unsorted_id = 0;	
		if(empty($temp)) {
			break;
		}

		$counter++;
		$UploadOk = true;

		if($_FILES["files"]["size"][$key] > $totalBytes) {
			$UploadOk = false;
			array_push($errors, $name." file size is larger than the 50 MB.");
		}

		$ext = pathinfo($name, PATHINFO_EXTENSION);

		if(in_array($ext, $extension) == false) {
			$UploadOk = false;
			array_push($errors, $name." is invalid file type.");
		}

		if(file_exists($UploadFolder."/".$name) == true) {
			$UploadOk = false;
			array_push($errors, $name." file is already exist.");
		}

		if($UploadOk == true) {
			move_uploaded_file($temp,$UploadFolder."/".$name);
			array_push($uploadedFiles, $name);

			$check = mysqli_query($con,"SELECT * FROM unsorted_images WHERE image='$name' ");
			//mysqli_num_rows($check);

			if (mysqli_num_rows($check)==0) {
				$sql= mysqli_query($con,"INSERT INTO unsorted_images(image,date,1st_level_sort) VALUES ('$name','$datetime','$unsorted_id')" );
			}
			else {

			}
		}
	}

	if($counter>0) {

		if(count($errors)>0) {
			echo "<b>Errors:</b>";
			echo "<br/><ul>";
			foreach($errors as $error)
			{
			echo "<li>".$error."</li>";
			}
			echo "</ul><br/>";
		}
		  
		if(count($uploadedFiles)>0) {
			echo "<b>Uploaded Files:</b>";
			echo "<br/><ul>";
			foreach($uploadedFiles as $fileName) {
				echo "<li>".$fileName."</li>";
			}
			echo "</ul><br/>";

			echo count($uploadedFiles)." file(s) are successfully uploaded.";
		}                               
	}
	else { 
		echo "Please, Select file(s) to upload.";
	}
}
if (isset($_POST["catsubmit"]) && isset($_GET['id'])) {
	$image_id = $_GET['id'];
	$chosen_category = $_POST['category'];  
	$query = "SELECT * FROM 1st_level_sort WHERE category = '$chosen_category' "; 
	$execute_query = mysqli_query($con,$query); 
	if (mysqli_num_rows($execute_query)>0) {
		while ($row=mysqli_fetch_array($execute_query)) {
			$id_of_chosen_category = $row['id'];
			$image_sort_query=mysqli_query($con,"UPDATE unsorted_images SET 1st_level_sort='$id_of_chosen_category' WHERE id='$image_id'"); 
			if ($image_sort_query>0) {
				include('redirection_page.php');
			} else {
				echo "Some Error has Occured";
			}	
		}	
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ImageSplatter.com</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style/my_style.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
	body,h1 {font-family: "Montserrat", sans-serif}
	img {margin-bottom: -7px}
	.w3-row-padding img {margin-bottom: 12px}
	</style>
</head>
<body>

<!-- Sidebar -->
<?php include('include/sidebar.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-content" style="max-width:1500px">

<!-- Header -->
<?php  include('include/header.php'); ?>

	<!-- Content -->
	<div class="upload_container">
	  <div class="up_heading">
	  	<h2 class="up_title">Upload Images</h2>
	  	<p class="up_desc">Select images that you want to upload [upto 20 at once]. Extension .jpg .jpeg .png .bmp .gif are allowed. File Size must not exceed 50MB.</p>
	  </div>
	  <form class="up_form" action="#" method="post" enctype="multipart/form-data" name="formUploadFile">   
	    <span class="up_file"><input type="file" name="files[]" multiple="multiple" required /></span>
	    <span class="up_submit"><input type="submit" value="Upload File" name="btnSubmit"/></span>
	  </form> 
	</div>

	<div class="category_container">
		<div>
			<h2>Choose Category</h2>
			<p>Select one category from the List. Selected Image will be stored under that category. Choose wisely.</p>
		</div>
			<?php
				if (isset($_GET['id'])) {
					$image_id = $_GET['id'];
			?>
				<div class="to_be_sorted">
					<div class="to_be_sorted_img_container">
						<?php show_image($image_id); ?>							
					</div>
				</div>
			<?php
				} else {
					"";
				}
			?>
		<form class="w3-container w3-card-4 cat_form_container" action="#" method="post">
			<select class="w3-select w3-border cat_select" name="category" required>
			    <option value="" disabled selected>Choose Category</option>
			    <?php show_1st_level_category_options(); ?>			    
  			</select>
  			<p><input class="w3-btn w3-teal cat_button" type="submit" value="Done" name="catsubmit" /></p>
		</form>
	</div>

<!-- End Page Content -->
</div>
<?php include('include/footer.php'); ?>