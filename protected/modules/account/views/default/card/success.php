<?php
/**
 * @var $sMessage
 */

$this->pageTitle = Yii::app()->name . " - Привязка банковской карты";
?>
	<h4>Привязка банковской карты</h4>

	<div class="alert alert-success in block"><?= $sMessage ?></div>
	<div class="clearfix"></div>

<?php if (Yii::app()->adminKreddyApi->checkSubscribe() && !SiteParams::getIsIvanovoSite()): ?>
	<div class="well">
		<?php    $this->widget('bootstrap.widgets.TbButton', array(
			'label' => 'Подключить КРЕДДИтную линию', 'icon' => "icon-ok icon-white", 'type' => 'primary', 'size' => 'small', 'url' => Yii::app()
					->createUrl('account/subscribe'),
		));?>
	</div>
<?php endif; ?>

<?php if (Yii::app()->adminKreddyApi->checkSubscribe() && SiteParams::getIsIvanovoSite()): ?>
	<div class="well">
		<?php    $this->widget('bootstrap.widgets.TbButton', array(
			'label' => 'Оформить займ', 'icon' => "icon-ok icon-white", 'type' => 'primary', 'size' => 'small', 'url' => Yii::app()
					->createUrl('account/subscribe'),
		));?>
	</div>
<?php endif; ?>


<?php if (Yii::app()->adminKreddyApi->checkLoan()): ?>
	<div class="well">
		<?php    $this->widget('bootstrap.widgets.TbButton', array(
			'label' => 'Получить займ', 'icon' => "icon-ok icon-white", 'type' => 'primary', 'size' => 'small', 'url' => Yii::app()
					->createUrl('account/loan'),
		));?>
	</div>
<?php endif; ?>