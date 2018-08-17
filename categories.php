<?php
session_start();
include('include/config.php');
include('functions.php');
validate_access();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ImageSplatter.com</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="HTML, CSS, XML, JavaScript, Image, Imaga Sorting, Pics, Pics Sorting">
    <meta name="author" content="Abhipriyo Biswas">

    <link rel="stylesheet" type="text/css" href="style/my_style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <style> body,h1 {font-family: "Montserrat", sans-serif} </style>
  </head>
  
  <style type="text/css">

* {
  box-sizing: border-box;
}

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev {
  left: 0;
}
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

  </style>

<body>

<!-- Sidebar -->
<?php include('include/sidebar.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-content" style="max-width:1500px">

  <!-- Header -->
  <?php include('include/header.php'); ?>

  <!-- Photo Grid Start-->
  <div class="category_container">
    <form class="w3-container w3-card-4 cat_form_container" action="#" method="post">
      <select class="w3-select w3-border cat_select" name="category" required>
        <option value="" disabled selected>Choose Category</option>
        <?php show_1st_level_category_options(); ?>         
      </select>
      <p><input class="w3-btn w3-teal cat_button" type="submit" value="Done" name="catsubmit" /></p>
    </form>
  </div>
  <div class="gallery_container">   
  <?php
    if (isset($_POST["catsubmit"])) {
      $chosen_category = $_POST["category"];
      $query = "SELECT * FROM 1st_level_sort WHERE category = '$chosen_category' "; 
      $execute_query = mysqli_query($con,$query); 
      if (mysqli_num_rows($execute_query)>0) {
        while ($row1=mysqli_fetch_array($execute_query)) {
          $id_of_chosen_category = $row1['id'];        
        } 
        $n = 1;
        $select_images_query = "SELECT * FROM unsorted_images WHERE 1st_level_sort = '$id_of_chosen_category' ";
        $run_query = mysqli_query($con,$select_images_query);
        if (mysqli_num_rows($run_query)>0) {
            while ($row2=mysqli_fetch_array($run_query)) {
  ?>
                <div class="img_card">
                  <img src="UploadFolder/<?php echo $row2["image"] ; ?> "/ style="width:100%" onclick="openModal();currentSlide(<?php echo $n; ?>)"> 
                </div>
  <?php
              $n = $n+1;
            }
        } else {
            echo "No Items to display";
        }
  ?>
        <div id="myModal" class="modal">
          <span class="close cursor" onclick="closeModal()">&times;</span>          
          <div class="modal-content">
          <a class="prev" onclick="plusSlides(-1)">&#10094;</a>  
          <?php
            $select_modal_image_query = "SELECT * FROM unsorted_images WHERE 1st_level_sort = '$id_of_chosen_category' ";
            $run_query2 = mysqli_query($con,$select_modal_image_query);
            if (mysqli_num_rows($run_query2)>0) {
              while ($row3=mysqli_fetch_array($run_query2)) {
          ?>
            <div class="mySlides">
              <img src="UploadFolder/<?php echo $row3["image"] ; ?> "/ style="width:100%">
            </div>     
          <?php
              }
            } else {
              echo "No Items to display";
            }  
          ?>          
          <a class="next" onclick="plusSlides(1)">&#10095;</a> 
          <?php
            $count = 1;
            $select_column_images_query = "SELECT * FROM unsorted_images WHERE 1st_level_sort = '$id_of_chosen_category' ";
            $run_query3 = mysqli_query($con,$select_column_images_query);
            if (mysqli_num_rows($run_query3)>0) {
              while ($row4=mysqli_fetch_array($run_query3)) {
          ?>
              <div class="column">
                <img class="demo cursor" src="UploadFolder/<?php echo $row4["image"] ; ?> "/ style="width:100%" onclick="currentSlide(<?php echo $count; ?>)">
              </div>
          <?php
                $count = $count + 1;      
              }
            } else {
              echo "No Items to display.";
            }
          ?>
  <?php
      } else {
        echo "No Items to display.";
      }
    }  
  ?>
          </div>
        </div>
  </div>
  <!-- Photo Grid End-->
  <script>
  function openModal() {
    document.getElementById('myModal').style.display = "block";
  }

  function closeModal() {
    document.getElementById('myModal').style.display = "none";
  }

  var slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    captionText.innerHTML = dots[slideIndex-1].alt;
  }
  </script>

<!-- End Page Content -->
</div>
<?php include('include/footer.php'); ?>  