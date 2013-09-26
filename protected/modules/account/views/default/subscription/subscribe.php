<?php
/* @var DefaultController $this */
/* @var ClientSubscribeForm $model */
/* @var IkTbActiveForm $form */

$this->pageTitle = Yii::app()->name . " - Подключение Пакета";
?>
	<h4>Подключение Пакета</h4>

<?php
$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'     => 'products-form',
	'action' => Yii::app()->createUrl('/account/doSubscribe'),
));

// если есть доступные пакеты для данного пользователя
$aClientProductsAndChannelsList = Yii::app()->adminKreddyApi->getClientProductsAndChannelsList();

if (!empty($aClientProductsAndChannelsList)) {
	$model->product = Yii::app()->adminKreddyApi->getSubscribeSelectedProduct();

	// если пакета в сессии нет
	if ($model->product === false) {
		//устанавливаем в качестве выбранного пакета первый из массива доступных
		$model->product = reset(array_keys($aClientProductsAndChannelsList));
	}

	echo $form->radioButtonList($model, 'product', $aClientProductsAndChannelsList, array("class" => "all",'uncheckValue' => $model->product));
	echo $form->error($model, 'product');

	?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'       => 'primary',
			'size'       => 'small',
			'label'      => 'Подключить Пакет',
		)); ?>
	</div>

<?php

} else { // если доступных пакетов нет - выводим соответствующее сообщение
	?>

	<div class="alert alert-info"><?= Yii::app()->adminKreddyApi->getNoAvailableProductsMessage() ?></div>

<?php
}
$this->endWidget();
