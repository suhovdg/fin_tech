<?php
/**
 * @var DefaultController $this
 * @var AddCardForm       $model
 * @var IkTbActiveForm    $form
 * @var                   $sVerify3DHtml
 */

$this->pageTitle = Yii::app()->name . " - Привязка банковской карты";
?>
	<h4>Привязка банковской карты</h4>


	<p>Ждите...</p>
<?php

//обновление страницы
Yii::app()->clientScript->registerScript('pageReload', '
	$(document).ready(function(){

            setInterval(function(){window.location.href=\'' . Yii::app()
		->createAbsoluteUrl(Yii::app()->request->requestUri) . '\';},20000);

        });
', CClientScript::POS_HEAD);
