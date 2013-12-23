<?php
/**
 * @var ClientCreateFormAbstract $oClientCreateForm
 * @var IkTbActiveForm           $form
 */

//TODO yaCounter21390544.reachGoal("expand_1");

$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'                   => get_class($oClientCreateForm),
	'enableAjaxValidation' => true,
	'type'                 => 'horizontal',
	'clientOptions'        => array(
		'validateOnChange' => true,
		'validateOnSubmit' => true,
	),
	'action'               => Yii::app()->createUrl('/form/'),
));

//снимаем все эвенты с кнопки, т.к. после загрузки ajax-ом содержимого эвент снова повесится на кнопку
//сделано во избежание навешивания кучи эвентов
Yii::app()->clientScript->registerScript('ajaxForm', '
		updateAjaxForm();
		');
?>

<?php $this->widget('YaMetrikaGoalsWidget'); ?>

<?php
$this->widget('FormProgressBarWidget', array('aSteps' => SiteParams::$aFormWidgetSteps, 'iCurrentStep' => (Yii::app()->clientForm->getCurrentStep() - 1)));
?>
<div class="clearfix"></div><h4>Личные данные</h4>
<div class="row">
	<div class="span5">
		<?= $form->textFieldRow($oClientCreateForm, 'last_name', SiteParams::getHintHtmlOptions($oClientCreateForm, 'last_name')); ?>
		<?= $form->textFieldRow($oClientCreateForm, 'first_name', SiteParams::getHintHtmlOptions($oClientCreateForm, 'first_name')); ?>
		<?= $form->textFieldRow($oClientCreateForm, 'third_name', SiteParams::getHintHtmlOptions($oClientCreateForm, 'third_name')); ?>
		<?= $form->dateMaskedRow($oClientCreateForm, 'birthday', SiteParams::getHintHtmlOptions($oClientCreateForm, 'birthday') + array('size' => '5', 'class' => 'inline')); ?>
	</div>
	<div class="span5 offset1">
		<?= $form->phoneMaskedRow($oClientCreateForm, 'phone', SiteParams::getHintHtmlOptions($oClientCreateForm, 'phone') + array('size' => '15')); ?>
		<?= $form->textFieldRow($oClientCreateForm, 'email', SiteParams::getHintHtmlOptions($oClientCreateForm, 'email')); ?>
		<?php //отдельный DIV ID для радиокнопок, для обработки в JS ?>
		<div id="sex">
			<?= $form->radioButtonListRow($oClientCreateForm, 'sex', Dictionaries::$aSexes, array('uncheckValue' => '999')); ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="span12">
		<?= $form->checkBoxRow($oClientCreateForm, 'complete'); ?>
	</div>
</div>
<div class="clearfix"></div>
<div class="row span10">
	<div class="form-actions">
		<div class="row">
			<div class="span1">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'url'   => Yii::app()->createUrl('/form/' . Yii::app()->clientForm->getCurrentStep()),
					'label' => 'Назад',
				)); ?>
			</div>

			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'          => 'submitButton',
				'buttonType'  => 'ajaxSubmit',
				'ajaxOptions' => array(
					'type'   => 'POST',
					'update' => '#formBody',
				),
				'url'         => Yii::app()->createUrl('/form/ajaxForm'),
				'type'        => 'primary',
				'label'       => 'Далее',
			)); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

<?php //TODO вынести текст в страницы, выдавать ajax-ом при нажатии на кнопку ?>

<!--div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4>Условия обслуживания и передачи информации</h4>
</div>

<div class="modal-body">
	<p>Заполняя и отправляя в адрес ООО «Финансовые Решения» (далее – Общество) данную форму анкеты и/или форму анкеты,
		заполненную мною дистанционным способом, я подтверждаю правильность указанных мною персональные данных,
		принадлежащих лично мне, а так же выражаю свое согласие на обработку (в том числе сбор, систематизацию,
		проверку, уточнение, изменение, обновление, использование, распространение (в том числе передачу третьим лицам),
		обезличивание, блокирование, уничтожение персональных данных) ООО «Финансовые Решения», место нахождения:
		Москва, Гончарная наб. д.1 стр.4, своих персональных данных, содержащихся в настоящей Анкете или переданных мною
		Обществу дистанционным способом. Персональные данные подлежат обработке (в том числе с использованием средств
		автоматизации) в целях принятия решения о предоставлении микрозайма, заключения, изменения, расторжения,
		дополнения, а также исполнения договоров микрозайма, дополнительных соглашений, заключенных или заключаемых
		впоследствии мною с ООО «Финансовые Решения». Настоящее согласие действует до момента достижения цели обработки
		персональных данных. Отзыв согласия на обработку персональных данных производится путем направления
		соответствующего письменного заявления Обществу по почте. Так же выражаю свое согласие на информирование меня
		Обществом о размерах микрозайма, полной сумме, подлежащей выплате, информации по продуктам или рекламной
		информации Общества по телефону, электронной почте, SMS – сообщениями.</p>

	<p>Направляя в ООО «Финансовые Решения» данную Анкету/или форму анкеты, заполненную мною дистанционным способом
		выражаю свое согласие на получение и передачу ООО «Финансовые Решения» (Общество) информации, предусмотренной
		Федеральным законом № 218 от 30.12.2004 "О кредитных историях", о своей кредитной истории в соответствующее бюро
		кредитных историй (Бюро кредитных историй определяет Общество по своему усмотрению). Список бюро указан на сайте
		Общества <a href="http://kreddy.ru/" target="_blank">www.kreddy.ru</a>, а также с тем, что в случае
		неисполнения, ненадлежащего исполнения и/или задержки исполнения мною своих обязательств по договорам
		микрозайма, заключенных с Обществом, Общество вправе раскрыть информацию об этом любым лицам (в т.ч.
		неопределенному кругу лиц) и любым способом (в т.ч. путем опубликования в средствах массовой информации).</p>

	<p>Направляя/подписывая в ООО «Финансовые Решения» данную форму Анкеты или анкету, заполненную мною дистанционным
		способом, подтверждаю, что ознакомлен с правилами предоставления микрозайма, со всеми условиями предоставления
		микрозайма. Также подтверждаю, что номер мобильного телефона, указанный в анкете, принадлежит лично мне.
		Ответственность за неправомерное использование номера мобильного телефона лежит на мне.</p>
</div-->


