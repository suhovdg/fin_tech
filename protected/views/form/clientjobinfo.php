<?php
/* @var FormController $this*/
/* @var ClientJobInfoForm $model*/
/* @var IkTbActiveForm $form*/
/* @var ClientCreateFormAbstract $oClientCreateForm */

/*
 * Место работы
 * Должность
 * Номер телефона
 * Стаж работы
 * Среднемесячный доход
 * Среднемесячный расход
 * Наличие кредитов и займов в прошлом
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
	<? require dirname(__FILE__) . '/fields/job.php' ?>
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
