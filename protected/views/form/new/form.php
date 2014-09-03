<?php
/**
 * @var FormController           $this
 * @var IkTbActiveForm           $form
 * @var ClientCreateFormAbstract $oClientCreateForm
 * @var string                   $sSubView
 */
?>


<div id="slider_wrapper" xmlns="http://www.w3.org/1999/html">
	<div id="mainpage_carousel" class="carousel slide" data-ride="carousel">
		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			<div class="item active">
				<span class="car_inner car_img1"></span>
			</div>
			<div class="item">
				<span class="car_inner car_img2"></span>
			</div>
			<div class="item">
				<span class="car_inner car_img3"></span>
			</div>
			<div class="item">
				<span class="car_inner car_img4"></span>
			</div>
			<div class="item">
				<span class="car_inner car_img5"></span>
			</div>
			<div class="item">
				<span class="car_inner car_img6"></span>
			</div>
		</div>
	</div>
	<div class="slider_form col-lg-8 col-md-9">
		<?php $this->renderPartial($sSubView, array('oClientCreateForm' => $oClientCreateForm)) ?>
	</div>
</div>

<div id="mid_block1">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0 mb1_ico">
				<div class="row">
					<div class="col-sm-3 col-xs-6">
						<div class="mb1_images">
							<img src="/static/newmain/images/mb1_img1.png" />

							<p>Деньги взаймы мгновенно</p>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
						<div class="mb1_images">
							<img src="/static/newmain/images/mb1_img2.png" />

							<p>В любом месте, где тебе удобно</p>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
						<div class="mb1_images">
							<img src="/static/newmain/images/mb1_img3.png" />

							<p>На карту или мобильный</p>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
						<div class="mb1_images">
							<img src="/static/newmain/images/mb1_img4.png" />

							<p>Круглосуточно 7 дней в неделю</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mb1_redtext">
			<a href="<?= Yii::app()->createUrl('/pages/view/tariffsdetails'); ?>">Подробнее о тарифах &#9658;</a>
		</div>
	</div>
</div>

<div class="page_separator"></div>

<div id="mid_block2">
	<div class="container">
		<div class="row">
			<!--<div class="col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0">-->
			<div class="col-xs-12">
				<div class="row">
					<div class="mb2_header">Получи деньги на карту или мобильный</div>
					<div class="col-sm-12 col-sm-offset-0 hidden-xs mb2_img">
						<img src="/static/newmain/images/kreddy_lg.jpg" />
					</div>
					<div class="col-xs-8 col-xs-offset-2 visible-xs mb2_img">
						<img src="/static/newmain/images/kreddi_sm.jpg" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="mid_block3">
	<div class="container">
		<div class="row hidden-xs">
			<div class="mb2_header">Оплати сервис любым удобным способом</div>
			<div class="col-sm-8 col-sm-offset-2 mb3_firstrow">
				<div class="row">
					<div class="col-xs-3 mb3_block">
						<a href="<?= Yii::app()->createUrl('pages/view/cc'); ?>"><img src="static/newmain/images/21.png" /> Банковская карта</a>
					</div>
					<div class="col-xs-3 mb3_block">
						<a href="<?= Yii::app()->createUrl('pages/view/mkb'); ?>"><img src="static/newmain/images/17.png" /> Терминал МКБ</a>
					</div>
					<div class="col-xs-3 mb3_block">
						<a href="<?= Yii::app()->createUrl('pages/view/qiwi'); ?>"><img src="static/newmain/images/18.png" /> QIWI-кошелек</a>
					</div>
					<div class="col-xs-3 mb3_block">
						<a href="<?= Yii::app()->createUrl('pages/view/elecsnet'); ?>"><img src="static/newmain/images/19.png" /> Терминал Элекснет</a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2">
				<div class="row">
					<div class="col-xs-4 mb3_block">
						<a href="<?= Yii::app()->createUrl('pages/view/paymobile'); ?>"><img src="static/newmain/images/22.png" /> Мобильный телефон</a>
					</div>
					<div class="col-xs-4 mb3_block">
						<a href="<?= Yii::app()->createUrl('pages/view/yandexmoney'); ?>"><img src="static/newmain/images/23.png" /> Яндекс-деньги</a>
					</div>
					<div class="col-xs-4 mb3_block">
						<a href="<?= Yii::app()->createUrl('pages/view/deltapay'); ?>"><img src="static/newmain/images/20.png" /> Терминал DeltaPay</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row visible-xs">
			<div class="mb2_header">Оплати сервис любым удобным способом</div>
			<div class="col-xs-12 col-xs-offset-0 mb3_firstrow">
				<div class="row">

					<div class="col-xs-6 mb3_block">
						<img src="static/newmain/images/21.png" /> <a href="<?= Yii::app()->createUrl('pages/view/cc'); ?>">Банковская карта1</a>
					</div>
					<div class="col-xs-6 mb3_block">
						<img src="static/newmain/images/17.png" /> <a href="<?= Yii::app()->createUrl('pages/view/mkb'); ?>">Терминал МКБ</a>
					</div>

					<div class="clearfix"></div>

					<div class="col-xs-6 mb3_block">
						<img src="static/newmain/images/22.png" /> <a href="<?= Yii::app()->createUrl('pages/view/paymobile'); ?>">Мобильный телефон</a>
					</div>
					<div class="col-xs-6 mb3_block">
						<img src="static/newmain/images/23.png" /> <a href="<?= Yii::app()->createUrl('pages/view/yandexmoney'); ?>">Яндекс-деньги</a>
					</div>

					<div class="clearfix"></div>

					<div class="col-xs-6 mb3_block">
						<img src="static/newmain/images/18.png" /> <a href="<?= Yii::app()->createUrl('pages/view/qiwi'); ?>">QIWI-кошелек</a>
					</div>
					<div class="col-xs-6 mb3_block">
						<img src="static/newmain/images/19.png" /> <a href="<?= Yii::app()->createUrl('pages/view/elecsnet'); ?>">Терминал Элекснет</a>
					</div>

					<div class="clearfix"></div>

					<div class="col-xs-12 mb3_block">
						<img src="static/newmain/images/20.png" /> <a href="<?= Yii::app()->createUrl('pages/view/deltapay'); ?>">Терминал DeltaPay</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="ask_block">
<div class="container">
	<div class="row">
		<div class="mb2_header ask_header">Задай вопрос</div>

		<div class="col-xs-12 col-xs-offset-0 ask_form soc_ask">
			<div class="row">

				<div class="col-xs-12">
					<div class="sa_block">

						<div class="savi savi_vk" id="vk">
							<div class="col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0">
								<script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
								<!-- VK Widget -->
								<div id="vk_groups"></div>
								<script type="text/javascript">
									VK.Widgets.Group("vk_groups", {mode: 0, width: "auto", height: "250", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 68363898);
								</script>
							</div>
						</div>

						<div class="savi savi_f" id="f">
							<div class="hidden-xs col-xs-12">
								<div class="fb-like-box" data-href="https://www.facebook.com/kreddyru" data-width="750px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
							</div>
							<div class="visible-xs">
								<div class="fb-like-box" data-href="https://www.facebook.com/kreddyru" data-width="290px" data-height="300px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
							</div>
						</div>

						<div class="savi savi_od" id="od">
							<div class="col-xs-12">
								<div id="ok_group_widget"></div>
								<script>
									!function (d, id, did, st) {
										var js = d.createElement("script");
										js.src = "http://connect.ok.ru/connect.js";
										js.onload = js.onreadystatechange = function () {
											if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
												if (!this.executed) {
													this.executed = true;
													setTimeout(function () {
														OK.CONNECT.insertGroupWidget(id, did, st);
													}, 0);
												}
											}
										}
										d.documentElement.appendChild(js);
									}(document, "ok_group_widget", "53026435498223", "{width:250,height:285}");
								</script>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="ask_siblock">
					<div class="ask_sibl ask_si1 act"></div>
					<div class="ask_sibl ask_si2"></div>
					<div class="ask_sibl ask_si3"></div>
					<div class="ask_sibl ask_si4"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 ask_form not_socask">
			<?php

			$model = new ContactForm;

			$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
				'id'                     => 'contact-form',
				'type'                   => 'inline',
				'action'                 => Yii::app()->createUrl('/site/faq/'),
				'enableClientValidation' => false,
			)); ?>

			<div class="col-sm-6 col-xs-12">
				<?php echo $form->textFieldRow($model, 'name', array('class' => 'askf_input')); ?>
			</div>
			<div class="col-sm-6 col-xs-12">
				<?php echo $form->phoneMaskedRow($model, 'phone', array('class' => 'askf_input')); ?>
			</div>
			<div class="clearfix"></div>
			<div class="col-sm-6 col-xs-12">
				<?php echo $form->textFieldRow($model, 'email', array('class' => 'askf_input')); ?>
			</div>
			<div class="col-sm-6 col-xs-12">
				<?php echo $form->textFieldRow($model, 'subject', array('class' => 'askf_input')); ?>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-12">
				<?php echo $form->textAreaRow($model, 'body', array('class' => 'askf_textar')); ?>
			</div>
			<div class="clearfix"></div>
			<?php if (CCaptcha::checkRequirements()): ?>
			<div class="ask_captcha hidden-xs">
				<div class="ascapleft">
					<p>Введите код сообщения
					<span style="width: 120px; display: inline-block; vertical-align: middle; "><?php $this->widget('CCaptcha',array('captchaAction'=>'site/captcha','buttonLabel'=>'обновить')); ?></span></p>
				</div>
				<div class="ascapright">
					<?php echo $form->textField($model, 'verifyCode', array('class' => 'askf_input input_captcha')); ?>
				</div>
			</div>
			<div class="ask_captcha2 visible-xs">
				<div class="col-xs-12 ascapleft2">
					<p>Введите код сообщения</p>
				</div>
				<div class="col-xs-12 ascapright2">
					<?php $this->widget('CCaptcha',array('captchaAction'=>'site/captcha','buttonLabel'=>'<br/>обновить')); ?><br />
					<?php echo $form->textField($model, 'verifyCode', array('class' => 'askf_input input_captcha')); ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="row">
				<?php
				$this->widget('bootstrap.widgets.TbButton', array(
					'id'         => 'send',
					'buttonType' => 'submit',
					'type'       => 'primary',
					'label'      => 'Спросить',
				));
				?>
			</div>

			<?php $this->endWidget(); ?>


		</div>
	</div>
</div>
<div class="container underask_block hidden-xs">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0 unas_wrap">
			<div class="row">
				<a href="<?= Yii::app()
					->createUrl('pages/view/smsinfopost'); ?>" class="col-sm-4 col-sm-offset-0 col-xs-3 col-xs-offset-1 unask_bl ua_bl1"><img src="/static/newmain/images/1.png" />SMS-инфо</a>

				<div class="col-sm-4 col-sm-offset-0 col-xs-3 col-xs-offset-1 unask_bl ua_bl2">
					<img src="/static/newmain/images/2.png" />Безопасность
				</div>
				<a href="<?= Yii::app()
					->createUrl('site/faq'); ?>" class="col-sm-4 col-sm-offset-0 col-xs-4 col-xs-offset-0 unask_bl ua_bl3"><img src="/static/newmain/images/3.png" />Вопросы
					и ответы</a>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 cards_block">
			<a target="_blank" href="https://kreddy.ru/static/docs/pcidss.pdf" class="pcard_block">
				<img src="/static/newmain/images/4.png" /> </a> <a href="#" class="pcard_block">
				<img src="/static/newmain/images/5.png" /> </a> <a href="#" class="pcard_block">
				<img src="/static/newmain/images/6.png" /> </a> <a href="#" class="pcard_block">
				<img src="/static/newmain/images/7.png" /> </a>
		</div>
	</div>
</div>
<div class="container underask_block_xs visible-xs">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0 unas_wrap">
			<div class="row">
				<a href="#" class="col-xs-12 unask_xs ua_xs1"><img src="/static/newmain/images/1.png" />SMS-инфо</a>

				<div class="col-xs-12 unask_xs ua_xs2"><img src="/static/newmain/images/2.png" />Безопасность</div>
				<div class="clearfix"></div>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-12 cards_block">
							<a target="_blank" href="https://kreddy.ru/static/docs/pcidss.pdf" class="pcard_block">
								<img src="/static/newmain/images/4.png" /> </a> <a href="#" class="pcard_block">
								<img src="/static/newmain/images/5.png" /> </a> <a href="#" class="pcard_block">
								<img src="/static/newmain/images/6.png" /> </a> <a href="#" class="pcard_block">
								<img src="/static/newmain/images/7.png" /> </a>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<a href="#" class="ccol-xs-12 unask_xs ua_xs3"><img src="/static/newmain/images/3.png" />Вопросы и
					ответы</a>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</div>
<?php $this->widget('YaMetrikaGoalsWidget'); ?>