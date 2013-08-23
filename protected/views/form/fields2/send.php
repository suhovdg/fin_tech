<?php
/**
 * @var ClientCreateFormAbstract $oClientCreateForm
 * @var IkTbActiveForm           $form
 */
?>
<?php
$htmlOptions = array(
	'errorOptions' => array(
		'afterValidateAttribute' => 'js: function(html){
			sendFormOk = false;
			if($("#personalData").hasClass("in")) $("#personalData").collapse("hide");
			if($("#passportData").hasClass("in")) $("#passportData").collapse("hide");
			if($("#address").hasClass("in")) $("#address").collapse("hide");
			if($("#jobInfo").hasClass("in")) $("#jobInfo").collapse("hide");
			var formName="' . get_class($oClientCreateForm) . '";
			var aAttrs = Array(
				"numeric_code",
				"secret_question",
				"secret_answer",
				"complete",
				"product"
			);
			var bFlag = true;
			var sAttrName;
			for(i=0;i<aAttrs.length;i++)
			{
				sAttrName = formName +"_"+aAttrs[i];
				if(!$("#"+sAttrName).parents(".control-group").hasClass("success")){
					bFlag = false;
				}
			}
			if(bFlag){
				sendFormOk = true;
			}
		}'
	)
);
//отдельно задаем свойства для радиокнопок, для корректной отработки валидации и сопутствующих JS
$productHtmlOptions = array('errorOptions' => $htmlOptions['errorOptions'] + array('id' => get_class($oClientCreateForm) . '_product'), 'uncheckValue' => '999');

?>
<div class="span5">
	<?= $form->textFieldRow($oClientCreateForm, 'numeric_code', array('class' => 'span3') + $htmlOptions); ?>
	<?= $form->dropDownListRow($oClientCreateForm, 'secret_question', Dictionaries::$aSecretQuestions, array('class' => 'span3') + $htmlOptions); ?>
	<?= $form->textFieldRow($oClientCreateForm, 'secret_answer', array('class' => 'span3') + $htmlOptions); ?>
	<?= $form->checkBoxRow($oClientCreateForm, 'complete', $htmlOptions); ?>
</div>
<?php //отдельный DIV ID для радиокнопок, для обработки в JS ?>
<div class="span6" id="product">
	<?php
	$oClientCreateForm->product = Yii::app()->clientForm->getSessionProduct();
	if (!isset($oClientCreateForm->product)) {
		$oClientCreateForm->product = "101";
	}
	?>
	<div id="product">
		<?php echo $form->radioButtonListRow($oClientCreateForm, 'product', Dictionaries::$aProducts2, array("class" => "all") + $productHtmlOptions); ?>
	</div>
	<?= $form->passwordFieldRow($oClientCreateForm, 'password', $htmlOptions); ?>
	<?= $form->passwordFieldRow($oClientCreateForm, 'password_repeat', $htmlOptions); ?>
</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'privacy')); ?>

<div class="modal-header">
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
</div>

<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'       => 'Закрыть',
		'url'         => '#',
		'htmlOptions' => array('data-dismiss' => 'modal'),
	)); ?>
</div>

<?php $this->endWidget(); ?>
