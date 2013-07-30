<?php
/* @var FormController $this*/
/* @var ClientAddressForm $model*/
/* @var IkTbActiveForm $form*/
/* @var ClientCreateFormAbstract $oClientCreateForm */

/*
 * Адрес:
 * + Регион
 * + Город
 * + Адрес
 * Контактное лицо:
 * + ФИО
 * + Номер телефона
 */


$this->pageTitle=Yii::app()->name;

$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
'id' => get_class($oClientCreateForm),
'enableAjaxValidation' => true,
'action' => '/form/',
));
?>

<div class="container">
<div class="row span12">
	<h2>Адрес</h2>
		<? require dirname(__FILE__) . '/fields/address_reg.php' ?>
</div>

<div class="row span12">
	<h2>Контактное лицо</h2>
		<? require dirname(__FILE__) . '/fields/relatives_one.php' ?>
</div>

	<div class="clearfix"></div>

	<div class="form-actions">
		<? $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => 'Далее →',
		)); ?>
	</div>

<?
$this->endWidget();
?>
</div>
