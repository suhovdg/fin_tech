<?php
/**
 * @var $this DefaultController
 * @var $smsState
 * @var $sIdentifyRender
 */

$this->breadcrumbs = array(
	$this->module->id,
);

$this->pageTitle = Yii::app()->name . ' - Ваш Пакет займов';

//подписка есть
$iAvailableLoans = Yii::app()->adminKreddyApi->getSubscriptionAvailableLoans();
?>

	<h4>Ваш Пакет займов</h4>

<?php if (Yii::app()->adminKreddyApi->getBalance() != 0) {
	// выводим сообщение, если баланс не равен 0
	?>
	<strong>Баланс:</strong>  <?= Yii::app()->adminKreddyApi->getBalance(); ?> руб. <br />
<?php } ?>

<?php if (!SiteParams::getIsIvanovoSite()): ?>
	<strong>Пакет:</strong> <?= Yii::app()->adminKreddyApi->getSubscriptionProduct() ?><br />
<?php endif; ?>

<?php if (SiteParams::getIsIvanovoSite()): ?>
	<strong>Сумма займа:</strong> <?= Yii::app()->adminKreddyApi->getSubscriptionLoanAmount() ?><br />
<?php endif; ?>

	<strong>Статус:</strong> <?= Yii::app()->adminKreddyApi->getStatusMessage() ?><br />

<?php if (Yii::app()->adminKreddyApi->getActiveLoanExpiredTo()) {
	// если есть займ, выводим дату возврата
	?>
	<strong>Возврат займа:</strong> <?= Yii::app()->adminKreddyApi->getActiveLoanExpiredTo() ?><br />
<?php } ?>
<?php if ($iAvailableLoans > 0): ?>
	<strong>Пакет активен до:</strong>  <?=
	(Yii::app()->adminKreddyApi->getSubscriptionActivity()) ?
		Yii::app()->adminKreddyApi->getSubscriptionActivity()
		: "&mdash;"; ?>
	<br />

	<strong>Доступно займов:</strong> <?= $iAvailableLoans; ?><br />
<?php endif; ?>

<?= $sIdentifyRender ?>