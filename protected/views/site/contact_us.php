<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form IkTbActiveForm */

?>

<?php if (Yii::app()->user->hasFlash('contact')): ?>

	<div class="alert alert-success in alert-block">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
	</div>

<?php else: ?>

	<p>Не нашли ответ в разделе «<a data-toggle="tab" href="#faq_tab_1">Частые вопросы</a>»? </p>

	<p>Вы всегда можете получить полную информацию у специалиста Контактного центра <b>8-800-555-75-78</b> или <b>задать
			свой вопрос на нашем сайте</b>. </p>

	<p>Мы с радостью ответим на Ваш вопрос о сервисе «Кредди». </p>


	<div class="form">

		<?php $form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
			'id'                     => 'contact-form',
			'enableClientValidation' => true,
			'clientOptions'          => array(
				'validateOnSubmit' => true,
			),
		)); ?>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->textFieldRow($model, 'name', array('class' => 'span4')); ?>
		</div>

		<div class="row">
			<?php echo $form->textFieldRow($model, 'email', array('class' => 'span4')); ?>
		</div>

		<div class="row">
			<?php echo $form->phoneMaskedRow($model, 'phone', array('class' => 'span4')); ?>
		</div>

		<div class="row">
			<?php echo $form->dropDownListRow($model, 'subject', Dictionaries::$aSubjectsQuestions, array('class' => 'span4')); ?>
		</div>

		<div class="row">
			<?php echo $form->textAreaRow($model, 'body', array('rows' => 10, 'cols' => 100, 'class' => 'span6')); ?>
		</div>

		<?php if (CCaptcha::checkRequirements()): ?>
			<div class="row">
				<?php echo $form->labelEx($model, 'verifyCode'); ?>
				<div>
					<?php $this->widget('CCaptcha'); ?><br />
					<?php echo $form->textField($model, 'verifyCode', array('class' => 'span4')); ?>
				</div>
				<?php echo $form->error($model, 'verifyCode'); ?>
			</div>
		<?php endif; ?>

		<div class="row">
			<?php
			$this->widget('bootstrap.widgets.TbButton', array(
				'id'         => 'send',
				'buttonType' => 'submit',
				'type'       => 'primary',
				'label' => 'Спросить',
			));
			?>
		</div>

		<?php $this->endWidget(); ?>

	</div><!-- form -->

<?php endif; ?>
