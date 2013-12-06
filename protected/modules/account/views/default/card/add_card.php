<?php
/* @var DefaultController $this */
/* @var AddCardForm $model */
/* @var IkTbActiveForm $form */
/* @var $sError */

$this->pageTitle = Yii::app()->name . " - Привязка банковской карты";

// путь до соответствующей картинки:
$sImagePath = (!empty($model->iCardType)) ? ('url(\'' . Yii::app()
		->getBaseUrl() . '/static/img/bankcard/icon-' . mb_convert_case(Dictionaries::$aCardTypes[$model->iCardType], MB_CASE_LOWER, 'utf-8') . '.gif\') ') : 'none';
?>
	<h4>Привязка банковской карты</h4>

<?php if (!empty($sError)): ?>
	<div class="alert alert-error"><?= $sError ?></div>
<?php endif; ?>


<?php
$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'          => 'add-card',
	'action'      => Yii::app()->createUrl('/account/addCard'),
	'htmlOptions' => array(
		'autocomplete' => 'off',
	)
));
?>
<?= $form->errorSummary($model) ?>

	<div class="alert alert-warning"><h4>Уважаемый Клиент:</h4>
		<ul>
			<li><?= AdminKreddyApiComponent::C_CARD_MSG_REQUIREMENTS; ?>
			</li>
			<?php
			//если карта уже привязана, то выдаем предупреждение
			if (Yii::app()->adminKreddyApi->getIsClientCardExists()): ?>
				<li>При привязке новой банковской карты, данные старой карты удаляются.</li>
			<?php endif; ?>
			<li>
				В данный момент перечисление займов доступно только на карты MasterCard. В ближайшее время перечисления
				станут доступны и на карты Visa. Благодарим за понимание!
			</li>
			<?php if (Yii::app()->adminKreddyApi->checkCardVerifyExists()): ?>
				<li>На Вашей карте будет заморожена случайная сумма не более чем на 2 часа. Обращаем Ваше внимание - на
					карте должно быть не менее 10 рублей.
				</li>
			<?php endif; ?>
		</ul>
		<p>
			<strong>Будьте внимательны! Количество попыток ввода данных строго ограничено.</strong>
		</p>
	</div>

<?= $form->hiddenField($model, 'iCardType') ?>

	<div style="background: url('/static/img/bankcard/cc-template.png'); width: 550px; height: 280px; margin-bottom: 15px;">
		<?= $form->textField($model, 'sCardPan', array('maxlength' => '20', "style" => "position: relative; top: 136px; left: 40px; width: 183px;", 'placeholder' => "1234567812345678")); ?>

		<?= $form->maskedTextField($model, 'sCardValidThru', ' 99 / 99 ', array("style" => "position: relative; top: 164px; left: -29px; width: 53px;")); ?>

		<?= $form->maskedTextField($model, 'sCardCvc', '999', array("style" => "position: relative; top: 132px; left: 132px; width: 32px;", 'size' => '3', 'maxlength' => '3')); ?>

		<?= $form->textField($model, 'sCardHolderName', array("style" => "position: relative; top: 191px; left: -276px; width: 183px;", 'placeholder' => "MR. CARDHOLDER")); ?>

		<div style="position: relative; top: 120px; left: 257px; width: 82px; height: 44px; background: <?= $sImagePath ?>" id="cardType"></div>
	</div>

<?= $form->checkBoxRow($model, 'bConfirm'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'       => 'primary',
			'size'       => 'small',
			'label'      => 'Привязать карту',
		));
		?>
	</div>
<?php

$this->endWidget();

Yii::app()->clientScript->registerCss('formstyle', '
input[type="text"] {
background-color: transparent;
border: 0px;
height: 14px;
}');

// TODO: добавить для visa
$sScript = 'oCardPan = $("#' . get_class($model) . '_sCardPan");
oCardTypeField = $("#' . get_class($model) . '_iCardType");
var regexp;

oCardPan.bind( "change click keydown keyup blur", function() {
	if(oCardPan.val() == ""){
		return;
	}

	$("#cardType").css("backgroundImage", "none");';

foreach (Dictionaries::$aCardTypes as $iKey => $oType) {
	$sScript .= '
	regexp = ' . Dictionaries::$aCardTypesRegexp[$iKey] . ';
	if(regexp.test($.trim(oCardPan.val()))) {
		oCardTypeField.val(' . $iKey . ');
		$("#cardType").css("backgroundImage", "url(' . Yii::app()
			->getBaseUrl() . '/static/img/bankcard/icon-' . mb_convert_case($oType, MB_CASE_LOWER, 'utf-8') . '.gif)");
	}';
}

$sScript .= '
});
';

Yii::app()->clientScript->registerScript('cardType', $sScript, CClientScript::POS_END);
