<?php
include('include/config.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box}
.mySlides1, .mySlides2 {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  height: 500px;
  margin: auto;
  max-width: 500px;
  position: relative;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a grey background color */
.prev:hover, .next:hover {
  background-color: #f1f1f1;
  color: black;
}
</style>
</head>
<body>

<h2 style="text-align:center">Multiple Slideshows</h2>

<p>Slideshow 1:</p>
<div class="slideshow-container">
 
<?php
  $count = 1;
  $query = mysqli_query($con,"SELECT * FROM unsorted_images WHERE 1st_level_sort=1");
  while ($row=mysqli_fetch_array($query)) {
?>
  
  <div class="mySlides1">
    <img src="UploadFolder/<?php echo $row["image"];?>" style="width:50%">
  </div>

<?php
    $count = $count+1;
  }
?>  
  <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
  <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
</div>

<p>Slideshow 2:</p>
<div class="slideshow-container">
  <div class="mySlides2">
    <img src="img_band_chicago.jpg" style="width:100%">
  </div>

  <div class="mySlides2">
    <img src="img_band_la.jpg" style="width:100%">
  </div>

  <div class="mySlides2">
    <img src="img_band_ny.jpg" style="width:100%">
  </div>

  <a class="prev" onclick="plusSlides(-1, 1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1, 1)">&#10095;</a>
</div>

<script>
var slideIndex = [1,1];
var slideId = ["mySlides1", "mySlides2"]
showSlides(1, 0);
showSlides(1, 1);

function plusSlides(n, no) {
  showSlides(slideIndex[no] += n, no);
}

function showSlides(n, no) {
  var i;
  var x = document.getElementsByClassName(slideId[no]);
  if (n > x.length) {slideIndex[no] = 1}    
  if (n < 1) {slideIndex[no] = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex[no]-1].style.display = "block";  
}
</script>

</body>
</html> 