<?php
require('include/config.php');

function validate_access() {
	if(!isset($_SESSION['id'])) { //checking if the session id is set
		header('location:login.php',true,303); //if id is not set redirect to index page
  		echo "Access Denied";
	}
	else {
 		echo ""; //if session is set do nothing
	}
}

function show_image($image_id) {
	global $con;
	$image = '';
	$query = 'SELECT * FROM unsorted_images WHERE id = '.$image_id.'';
	$execute_query = mysqli_query($con,$query);
	while ($row=mysqli_fetch_assoc($execute_query)) {
		$image = '<img src="UploadFolder/'.$row["image"].'"/ style = "width:100%">';
		echo $image;
	}
}

function show_images($table_name,$_1st_level_sort_id,$ascending_or_decending) {
	global $con; //using globally declared $con in function
	$images = ''; //Empty variable to hold the HTML
	//$total_images_to_display = 20; //No. of Images to display
	$n=1; //counter
	$query = 'SELECT * FROM '.$table_name.' WHERE 1st_level_sort = '.$_1st_level_sort_id .' ORDER BY id '.$ascending_or_decending ;
	$run_query = mysqli_query($con,$query);	
	if (mysqli_num_rows($run_query) > 0) {
		while ($row=mysqli_fetch_array($run_query)) {
			$image_id = $row['id']; //Storing id of each image 
			$images = ' <div class="img_card">
							<img src="UploadFolder/'.$row["image"].' "/ style="width:100%"> 
						</div> ';			
			echo $images; //Printing HTML code stored in $images 
			// $total_images_to_display = $total_images_to_display-1; 
			// if ($total_images_to_display == 0) {
			// 	break;
			// }			
		}
	} else {
		echo "0 results";
	}	
	//return $images;
}

function show_all_images($table_name,$_1st_level_sort_id,$ascending_or_decending) {
	global $con; 
	$images = '';
	$query = 'SELECT * FROM '.$table_name.' WHERE 1st_level_sort = '.$_1st_level_sort_id .' ORDER BY id '.$ascending_or_decending ;
	$run_query = mysqli_query($con,$query);	
	if (mysqli_num_rows($run_query) > 0) {
		while ($row=mysqli_fetch_array($run_query)) {
			$image_id = $row['id']; 
			$test = "show_1st_level_category_options()"; 
			$image_path = "UploadFolder/".$row["image"]; 
			//echo $image_path; exit();
			$images = ' <div class="img_card" 
							style=" 
							background:url('.$image_path.'); 
							background-repeat: no-repeat;
							background-position: 0 0;
							background-size: cover;
						">
							<div class="icon"><a href="operations.php?id='.$image_id.'"><i class="fa fa-paperclip"></i></a></div>
						 </div> ';			
			echo $images;		
		}
	} else {
		echo "0 results";
	}	
	//return $images;
}

function show_1st_level_category_options() {
	global $con;
	$options = "";
	$cat_query = mysqli_query($con,"SELECT * FROM 1st_level_sort");	
	while ($row = mysqli_fetch_array($cat_query)) {
		$options = "<option>".$row['category']."</option>";		
		echo $options;
	}
}

function fetch_and_return_id($id) {
	return $id;
}

// function categorize_image($table_name,$image_id,$chosen_category) { //Didn't work
// 	global $con; 
// 	$query = 'SELECT * FROM '.$table_name.' WHERE category = '.$chosen_category.'';  
// 	$execute_query = mysqli_query($con,$query); echo $execute_query; exit();
// 	if (mysqli_num_rows($execute_query)>0) {
// 		while ($row=mysqli_fetch_array($execute_query)) {
// 			$id_of_chosen_category = $row['id'];
// 			$image_sort_query=mysqli_query($con,"UPDATE unsorted_images SET '$table_name'='$id_of_chosen_category' WHERE id='$image_id'"); 
// 			if ($sort_query>0) {
// 				echo "Image added to ".$chosen_category;
// 			} else {
// 				echo "Some Error has Occured";
// 			}	
// 		}	
// 	}
// }
