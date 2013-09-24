<?php
/* @var FormController $this */
/* @var ClientSelectProductForm $model */
/* @var IkTbActiveForm $form */
/* @var ClientCreateFormAbstract $oClientCreateForm */

/*
 * Выбор суммы займа
 */

$this->pageTitle = Yii::app()->name;

$aCrumbs = array(
	array('Выбор Пакета', 1),
	array('Знакомство', 2),
	array('Заявка на займ', 5, 3)
);

?>

<div class="row">

	<?php $this->widget('CheckBrowserWidget'); ?>

	<?php $this->widget('StepsBreadCrumbsWidget', array('aCrumbs' => $aCrumbs)); ?>

	<?php

	$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
		'id'                   => get_class($oClientCreateForm),
		'enableAjaxValidation' => true,
		'clientOptions'        => array(
			'validateOnChange' => true,
			'validateOnSubmit' => true,
		),
		'action'               => Yii::app()->createUrl('/form/'),
	));

	?>
	<div class="row span6">
		<img src="<?= Yii::app()->request->baseUrl; ?>/static/img/01T.png" />
		<?php
		$oClientCreateForm->product = Yii::app()->clientForm->getSessionProduct();
		if (!isset($oClientCreateForm->product)) {
			$oClientCreateForm->product = "101";
		}
		?>
		<?= $form->radioButtonListRow($oClientCreateForm, 'product', Dictionaries::getProducts(), array("class" => "all")); ?>

	</div>

	<?php $this->widget('ChosenConditionsWidget', array(
		'curStep' => Yii::app()->clientForm->getCurrentStep() + 1,
	)); ?>

	<div class="clearfix"></div>
	<div class="row span11">
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType' => 'submit',
				'type'       => 'primary',
				'label'      => 'Далее →',
			)); ?>
		</div>
	</div>
	<?php

	$this->endWidget();

	?>

	<?php $this->widget('YaMetrikaGoalsWidget', array(
		'iDoneSteps' => Yii::app()->clientForm->getCurrentStep(),
	)); ?>

</div>
