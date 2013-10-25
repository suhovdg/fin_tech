<?php
/**
 * @var $this DefaultController
 * @var $smsState
 * @var $passFormRender
 */

$this->breadcrumbs = array(
	$this->module->id,
);

$this->pageTitle = Yii::app()->name . ' - Ваш Пакет займов';

//подписка есть
?>

<h4>Ваш Пакет займов</h4>

<?php if (Yii::app()->adminKreddyApi->getBalance() != 0) {
	// выводим сообщение, если баланс не равен 0
	?>
	<strong>Баланс:</strong>  <?= Yii::app()->adminKreddyApi->getBalance(); ?> руб. <br />
<?php } ?>

<strong>Пакет:</strong> <?= Yii::app()->adminKreddyApi->getSubscriptionProduct() ?><br />

<strong>Статус:</strong> <?= Yii::app()->adminKreddyApi->getStatusMessage() ?><br />

<strong>Пакет активен до:</strong>  <?=
(Yii::app()->adminKreddyApi->getSubscriptionActivity()) ?
	Yii::app()->adminKreddyApi->getSubscriptionActivity()
	: "&mdash;"; ?>
<br />

<strong>Доступно займов:</strong> <?= Yii::app()->adminKreddyApi->getSubscriptionAvailableLoans(); ?><br /><br />

<div class="clearfix"></div>
<div class="well">
	Вы можете оформить займ <?= Yii::app()->adminKreddyApi->getMoratoriumLoan() ?>
	<br />
</div>
<div class="clearfix"></div>
<br />
<?= $passFormRender // отображаем форму запроса SMS-пароля ?>

