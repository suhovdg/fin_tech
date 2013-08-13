<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-overload.css" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/style.css" type="text/css" />

	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
</head>
<body>
<div style="width:400px">
	<div id="instructions">Разрешите использование веб-камеры, если она есть, чтобы пройти видеоидентификацию</div>
	<canvas id="inputCanvas" width="400" height="300" style="display: none; -webkit-transform: scaleX(-1); transform: scaleX(-1);"></canvas>
	<video id="inputVideo" width="100%" autoplay loop style="height: 320px; -webkit-transform: scaleX(-1); transform: scaleX(-1);"></video>
	<canvas id="overlay"></canvas>
</div>
<script type="text/javascript" src="<?= Yii::app()->request->baseUrl ?>/static/js/headtrackr.js"></script>

<script type="text/javascript">
	$(function () {
		var video = document.getElementById('inputVideo');
		var canvas = document.getElementById('inputCanvas');
		var canvasOverlay = document.getElementById('overlay');
		var contextOverlay = canvasOverlay.getContext('2d');
		var inRectangle = false;
		//запускаем трекер лица
		var headTracker = new headtrackr.Tracker({
			ui: false
		});
		headTracker.init(video, canvas);
		document.addEventListener('headtrackrStatus', function (event) {
			if (event.status == 'camera found') {

			}
		});
	});
</script>
</body>
</html>
