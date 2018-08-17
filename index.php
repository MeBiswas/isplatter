<?php
require('include/config.php');
require('functions.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
<body>

<!-- Sidebar -->
<?php include('include/sidebar_index.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-content" style="max-width:1500px">

<!-- Header -->
<?php include('include/header.php'); ?>

<!-- Photo Grid Start-->
<div class="gallery_container">
  <?php show_images("unsorted_images","0","DESC"); ?>  
</div>
<!-- Photo Grid End-->

<!-- End Page Content -->
</div>
<?php include('include/footer.php'); ?>