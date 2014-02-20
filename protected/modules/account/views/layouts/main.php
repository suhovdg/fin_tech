<?php /* @var $this Controller */
/* @var $content */
?>
<!DOCTYPE html>
<html lang="en">

<head><!-- head start -->
	<?php $this->beginContent('//layouts/main_head');
	echo $content;
	$this->endContent();
	?>
	<!-- head end -->
</head>

<body class="home">
<!--  header navbar start -->
<?php $this->beginContent('/layouts/main_navbar_top');
echo $content;
$this->endContent();
?>
<!--  header navbar end -->
<div class="left-stars-23feb"></div>
<div class="right-stars-23feb"></div>
<!-- main content start-->
<div class="main-bgr-23feb">
	<br />
	<?= $content; ?>
	<br />
</div>
<!-- main content end-->
<!-- footer start-->
<?php $this->beginContent('//layouts/main_footer');
echo $content;
$this->endContent();
?>
<!-- footer start-->

</body>
</html>
