<?php

/**
 * Class AdminKreddyApiComponent
 *
 */
class AdminKreddyApiComponent
{

	/**
	 * Статусы API
	 */

	const C_CLIENT_NEW = 'client_new';
	const C_CLIENT_ACTIVE = 'client_active';
	const C_CLIENT_FAST_REG = 'client_fast_reg';

	const C_CLIENT_MORATORIUM_LOAN = 'client_moratorium_loan';
	const C_CLIENT_MORATORIUM_SUBSCRIPTION = 'client_moratorium_subscription';
	const C_CLIENT_MORATORIUM_SCORING = 'client_moratorium_scoring';

	const C_SCORING_PROGRESS = 'scoring_progress';
	const C_SCORING_AWAITING_REIDENTIFY = 'scoring_awaiting_reidentify';
	const C_SCORING_CANCEL = 'scoring_cancel';
	const C_SCORING_ACCEPT = 'scoring_accept';

	const C_SUBSCRIPTION_AVAILABLE = 'subscription_available';
	const C_SUBSCRIPTION_PAYMENT = 'subscription_payment';
	const C_SUBSCRIPTION_PAID = 'subscription_paid';
	const C_SUBSCRIPTION_CANCEL = 'subscription_cancel';
	const C_SUBSCRIPTION_ACTIVE = 'subscription_active';
	const C_SUBSCRIPTION_AWAITING_CONFIRMATION = 'subscription_awaiting_confirmation';

	const C_LOAN_AVAILABLE = 'loan_available';
	const C_LOAN_CREATED = 'loan_created';
	const C_LOAN_TRANSFER = 'loan_transfer';
	const C_LOAN_ACTIVE = 'loan_active';
	const C_LOAN_DEBT = 'loan_debt';
	const C_LOAN_PAID = 'loan_paid';
	const C_LOAN_REQUEST = 'loan_request';
	const C_LOAN_CONFIRMED = 'loan_confirmed';

	const C_STATUS_ERROR = 'Ошибка!';

	const C_SUBSCRIPTION_NOT_AVAILABLE = "Упс… Извини, перевод недоступен. {account_url_start}Посмотреть информацию о подключении{account_url_end}";
	const C_SUBSCRIPTION_NOT_AVAILABLE_IVANOVO = "Извините, оформление займа недоступно. {account_url_start}Посмотреть информацию о статусе займа{account_url_end}";
	const C_LOAN_NOT_AVAILABLE = "Перевод недоступен. Попробуй повторить запрос на перевод через 1 минуту. {account_url_start}Посмотреть информацию о подключении{account_url_end}";
	const C_DO_SUBSCRIBE_MSG_SCORING_ACCEPTED = 'Поздравляем! Заявка на {loan_amount} р. одобрена! Оплати абонентку {do_sub_pay_sum} р. любым удобным способом для подключения сервиса на месяц {account_url_start}Посмотреть информацию о КРЕДДИтной линии{account_url_end}';
	const C_DO_SUBSCRIBE_MSG_SCORING_ACCEPTED_POSTPAID = 'Заявка одобрена. Для получения денег {do_loan_url_start}отправьте запрос на перевод.{do_loan_url_end}';
	const C_DO_SUBSCRIBE_MSG_SCORING_CANCELED = 'Sorry…Твоя заявка отклонена';
	const C_DO_SUBSCRIBE_MSG = 'Ура! Запрос на подключение сервиса принят. Мы отправим СМСку с решением на твой мобильный.';
	const C_DO_LOAN_MSG = 'Деньги успешно отправлены';
	const C_SESSION_EXPIRED = 'Время сессии истекло. Необходимо снова зайти в личный кабинет.';
	const C_SESSION_TIME_UNTIL_EXPIRED = 'Время сессии: ';
	const C_CARD_NOT_AVAILABLE = 'Перевод на карту недоступен. Для получения денег, необходимо пройти процедуру привязки банковской карты в личном кабинете.';

	private $aSubscriptionActiveStates = array(
		self::C_SUBSCRIPTION_ACTIVE,
		self::C_SUBSCRIPTION_PAID,
		self::C_LOAN_AVAILABLE,
		self::C_LOAN_ACTIVE,
		self::C_LOAN_REQUEST,
		self::C_LOAN_CONFIRMED,
		self::C_LOAN_CREATED,
		self::C_LOAN_TRANSFER,
		self::C_LOAN_DEBT,
		self::C_LOAN_PAID,
		self::C_CLIENT_MORATORIUM_LOAN,
	);

	private $aAvailableStatuses = array(

		self::C_CLIENT_MORATORIUM_LOAN             => 'Перевод денег временно недоступен',
		self::C_CLIENT_MORATORIUM_SCORING          => 'Заявка отклонена',
		self::C_CLIENT_MORATORIUM_SUBSCRIPTION     => 'Подключение сервиса временно недоступно',

		self::C_SUBSCRIPTION_ACTIVE                => 'Сервис подключен',
		self::C_SUBSCRIPTION_AVAILABLE             => 'Подключение к сервису доступно',
		self::C_SUBSCRIPTION_CANCEL                => 'Срок внесения абонентки истек',
		self::C_SUBSCRIPTION_PAID                  => 'Сервис подключен, теперь ты можешь пользоваться деньгами',

		self::C_SUBSCRIPTION_PAYMENT               => 'Поздравляем! Заявка на {loan_amount} р. одобрена. Оплати абонентку в размере {sub_pay_sum} рублей для подключения сервиса на месяц. {payments_url_start}Подробнее{payments_url_end}',
		self::C_SUBSCRIPTION_AWAITING_CONFIRMATION => 'Поздравляем! Заявка на {loan_amount} р. одобрена. Теперь ты можешь подключить сервис КРЕДДИ',

		self::C_SCORING_PROGRESS                   => 'Твоя заявка в обработке. {account_url_start}Обновить статус{account_url_end}', //+
		self::C_SCORING_AWAITING_REIDENTIFY        => 'Необходимо пройти повторную идентификацию',
		self::C_SCORING_ACCEPT                     => 'Твоя заявка одобрена. Деньги успешно отправлены.',
		self::C_SCORING_CANCEL                     => 'Заявка отклонена',

		self::C_LOAN_DEBT                          => 'Непогашенная задолженность',
		self::C_LOAN_ACTIVE                        => 'Деньги отправлены', //+
		self::C_LOAN_TRANSFER                      => 'Деньги отправлены', //+
		self::C_LOAN_AVAILABLE                     => 'Сервис подключен, теперь ты можешь пользоваться деньгами',
		self::C_LOAN_CREATED                       => 'Деньги отправлены', //+
		self::C_LOAN_PAID                          => 'Спасибо! Мы все получили. Задолженность полностью погашена.',
		self::C_LOAN_REQUEST                       => 'Необходимо подтвердить условия',
		self::C_LOAN_CONFIRMED                     => 'Индивидуальные условия приняты',

		self::C_CLIENT_ACTIVE                      => 'Подключение сервиса доступно', //+
		self::C_CLIENT_NEW                         => 'Подключи сервис',
		self::C_CLIENT_FAST_REG                    => 'Требуется заполнить анкету',
	);

	private $aAvailableStatusesIvanovo = array(

		self::C_CLIENT_MORATORIUM_LOAN         => 'Временно недоступно получение новых займов',
		self::C_CLIENT_MORATORIUM_SCORING      => 'Заявка отклонена',
		self::C_CLIENT_MORATORIUM_SUBSCRIPTION => 'Временно недоступно получение новых займов',

		self::C_SUBSCRIPTION_ACTIVE            => 'Займ оформлен',
		self::C_SUBSCRIPTION_AVAILABLE         => 'Доступно оформление займа',
		self::C_SUBSCRIPTION_CANCEL            => '', //для Иваново не должно использоваться
		self::C_SUBSCRIPTION_PAID              => 'Сервис подключен, теперь ты можешь пользоваться деньгами',

		self::C_SUBSCRIPTION_PAYMENT           => '', //для Иваново не должно использоваться

		self::C_SCORING_PROGRESS               => 'Твоя заявка в обработке. {account_url_start}Обновить статус{account_url_end}', //+

		self::C_SCORING_ACCEPT                 => 'Ваша заявка одобрена, ожидайте выдачи займа',
		self::C_SCORING_CANCEL                 => 'Заявка отклонена',

		self::C_LOAN_DEBT                      => 'Задолженность по займу',
		self::C_LOAN_ACTIVE                    => 'Деньги отправлены',
		self::C_LOAN_TRANSFER                  => 'Деньги отправлены',
		self::C_LOAN_AVAILABLE                 => 'Сервис подключен, теперь ты можешь пользоваться деньгами',
		self::C_LOAN_CREATED                   => 'Деньги отправлены',
		self::C_LOAN_PAID                      => 'Деньги отправлены',

		self::C_CLIENT_ACTIVE                  => 'Доступно оформление займа',
		self::C_CLIENT_NEW                     => 'Выберите займ',
	);

	const C_MOBILE = 'mobile';
	const C_CARD = 'card';

	const PRODUCT_TYPE_KREDDY = 1;
	const PRODUCT_TYPE_IVANOVO = 2;
	const PRODUCT_TYPE_KREDDYLINE = 3;
	const PRODUCT_TYPE_KREDDY_LINE_POSTPAID = 4;
	const PRODUCT_TYPE_KREDDY_PERCENT_PREPAID = 5;
	const PRODUCT_TYPE_KREDDY_PERCENT_POSTPAID = 6;

	public static $aPostPaidProducts = array(
		self::PRODUCT_TYPE_KREDDY_LINE_POSTPAID,
		self::PRODUCT_TYPE_KREDDY_PERCENT_POSTPAID
	);

	const C_KREDDY_LINE_POSTPAID_PAY_RULES = 'до окончания действия сервиса';
	const C_KREDDY_LINE_PAY_RULES = 'перед началом использования сервиса';

	private static $aChannels = array(
		self::C_MOBILE,
		self::C_CARD,
	);

	/**
	 * @var array массив каналов с рег.выражениями - на карту и на мобильный
	 */
	private static $aChannelsRegexps = array(
		self::C_MOBILE => '/мобил/',
		self::C_CARD   => '/карт/',
	);

	const ERROR_NONE = 0; //нет ошибок
	const ERROR_UNKNOWN = 1; //неизвестная ошибка
	const ERROR_AUTH = 2; //ошибка авторизации
	const ERROR_TOKEN_DATA = 3; //ошибочные данные в токене
	const ERROR_TOKEN_VERIFY = 4; //ошибка проверки токена
	const ERROR_TOKEN_EXPIRE = 5; //токен просрочен
	const ERROR_TOKEN_NOT_EXIST = 6; //токен не существует
	const CLIENT_NOT_EXIST = 7; //клиент не существует
	const CLIENT_DATA_NOT_EXIST = 8; //данные клиента не существуют
	const ERROR_NEED_SMS_AUTH = 9; //требуется СМС-авторизация
	const ERROR_NEED_SMS_CODE = 10; //требуется подтверждение СМС-кодом
	const ERROR_NOT_ALLOWED = 11; //действие недоступно
	const ERROR_VALIDATION = 24; //ошибка валидации
	const ERROR_CLIENT_EXISTS = 15; //ошибка номера телефона или email (такой номер или email уже есть)
	const ERROR_NEED_IDENTIFY = 16; //требуется идентификация
	const ERROR_NEED_PASSPORT_DATA = 17; //требуется ввести паспортные данные
	const ERROR_NEED_REDIRECT = 18; //требуется редирект на основной домен сайта
	const ERROR_NEED_CARD = 202; //требуется привязать банковскую карту

	/**
	 * Требуется подождать и повторить запрос
	 */
	const ERROR_NEED_WAIT = 203;

	/**
	 * Требуется пройти процесс 3DS авторизации
	 */
	const ERROR_NEED_3DS_PROCESS = 204;

	/**
	 * Ошибка в процессе верификации карты через 3DS
	 */
	const ERROR_VERIFY_3DS = 205;

	const SMS_AUTH_OK = 0; //СМС-авторизация успешна (СМС-код верный)
	const SMS_SEND_OK = 1; //СМС с кодом/паролем отправлена
	const SMS_CODE_ERROR = 2; //неверный СМС-код
	const SMS_BLOCKED = 3; //отправка СМС заблокирована
	const SMS_CODE_TRIES_EXCEED = 4; //попытки ввода СМС-кода исчерпаны

	const TOKEN_MINUTES_LIVE = 10; // токен живёт 10 минут

	const API_ACTION_CHECK_IDENTIFY = 'video/heldIdentification';
	const API_ACTION_GET_IDENTIFY = 'video/getIdentify';
	const API_ACTION_CREATE_CLIENT = 'siteClient/signup';
	const API_ACTION_CREATE_FAST_REG_CLIENT = 'siteClient/signupFast';
	const API_ACTION_UPDATE_FAST_REG_CLIENT = 'siteClient/updateFastReg';
	const API_ACTION_CHECK_SUBSCRIBE = 'siteClient/checkSubscribe';
	const API_ACTION_DO_CONFIRM_SUBSCRIPTION = 'siteClient/doConfirmSubscription';
	const API_ACTION_SUBSCRIBE = 'siteClient/doSubscribe';
	const API_ACTION_CHECK_LOAN = 'siteClient/checkLoan';
	const API_ACTION_CHECK_CONFIRM_LOAN = 'siteClient/checkConfirmLoan';
	const API_ACTION_LOAN_CONFIRM = 'siteClient/doConfirmLoan';
	const API_ACTION_LOAN = 'siteClient/doLoan';
	const API_ACTION_TOKEN_UPDATE = 'siteToken/update';
	const API_ACTION_TOKEN_CREATE = 'siteToken/create';
	const API_ACTION_GET_INFO = 'siteClient/getInfo';
	const API_ACTION_GET_FULL_CLIENT_DATA = 'siteClient/getFullClientData';
	const API_ACTION_GET_HISTORY = 'siteClient/getPaymentHistory';
	const API_ACTION_RESET_PASSWORD = 'siteClient/resetPassword';
	const API_ACTION_GET_PRODUCTS = 'siteClient/getProducts';
	const API_ACTION_CHANGE_PASSPORT = 'siteClient/doChangePassport';
	const API_ACTION_CHANGE_SECRET_QUESTION = 'siteClient/doChangeSecretQuestion';
	const API_ACTION_CHANGE_SMS_AUTH_SETTING = 'siteClient/doChangeSmsAuthSetting';
	const API_ACTION_GET_LOAN = 'siteClient/getLoan';
	const API_ACTION_CHANGE_NUMERIC_CODE = 'siteClient/doChangeNumericCode';
	const API_ACTION_CHANGE_PASSWORD = 'siteClient/doChangePassword';
	const API_ACTION_UPLOAD_DOCUMENT = 'siteClient/uploadDocument';
	const API_ACTION_SET_IDENTIFICATION_FINISHED = 'siteClient/setFinishedVideoId';
	const API_ACTION_CANCEL_REQUEST = 'siteClient/doCancelRequest';
	const API_ACTION_CANCEL_LOAN_REQUEST = 'siteClient/doCancelLoanRequest';
	const API_ACTION_CHANGE_EMAIL = 'siteClient/doChangeEmail';
	const API_ACTION_GET_INDIVIDUAL_CONDITION_INFO = 'siteClient/getIndividualConditionInfo';
	const API_ACTION_GET_INDIVIDUAL_CONDITION_LIST = 'siteClient/getIndividualConditionList';

	const API_ACTION_CHECK_SMS_CODE = 'siteClient/authBySms';

	const API_ACTION_ADD_CARD = 'siteClientCard/addClientCard';
	const API_ACTION_VERIFY_CARD = 'siteClientCard/verifyClientCard';
	const API_ACTION_CHECK_CAN_VERIFY_CARD = 'siteClientCard/checkClientCanVerifyCard';

	const API_ACTION_EMAIL_INFO = 'siteEmail/emailLinkHandler';

	const API_ACTION_SEND_SMS = 'siteClient/sendSms';
	const API_ACTION_SEND_EMAIL_CODE = 'siteClient/sendEmailCode';

	const ERROR_MESSAGE_UNKNOWN = 'Произошла неизвестная ошибка. Проверьте правильность заполнения данных.';
	const C_NO_AVAILABLE_PRODUCTS = "Доступные способы перечисления денег отсутствуют.";

	const C_CARD_MSG_REQUIREMENTS = 'Убедись, что банковская карта зарегистрирована на твое имя, не является предоплаченной, активна (не заблокирована) и доступна для перечисления денег.';
	const C_CARD_WARNING_NO_CARD = 'ВНИМАНИЕ! У тебя нет привязанной банковской карты. Для получения денег на банковскую карту пройди процедуру привязки карты.';
	const C_CARD_WARNING_EXPIRED = 'ВНИМАНИЕ! У ранее привязанной банковской карты вышел срок действия привязки и необходимо привязать ту же самую или новую карту.';
	const C_CARD_SUCCESSFULLY_VERIFIED = "Карта успешно привязана!";
	const C_CARD_ADD_TRIES_EXCEED = "Сервис временно недоступен. Попробуй позже.";
	const C_CARD_VERIFY_EXPIRED = "Время проверки карты истекло. Для повторения процедуры привязки введи данные карты.";
	const C_CARD_VERIFY_ERROR_3DS = "При авторизации карты произошла ошибка. Возможно, неверно введены данные карты или код авторизации. Попробуй повторить процедуру привязки карты.";
	const C_CARD_AGREEMENT = "Время зачисления денег зависит от банка-эмитента твоей карты. В некоторых случаях срок зачисления может составлять несколько дней. Обращаем твое внимание, МФО ООО «Финансовые Решения» оставляет за собой право увеличить срок возврата денег, указанный в Приложение №1 к Договору (Оферте), не более, чем на 3 дня.";

	const C_REQUEST_CANCEL_SUCCESS = 'Твоя заявка на подключение успешно отменена. Будем ждать новой заявки!';
	const C_REQUEST_CANCEL_ERROR = 'Ошибка! Не удалось отменить подключение.';

	const C_LOAN_REQUEST_CANCEL_SUCCESS = 'Индивидуальные условия успешно отклонены. Ты всегда можешь отправить запрос на перевод денег повторно.';
	const C_LOAN_REQUEST_CANCEL_ERROR = 'Ошибка! Не удалось отказаться от индивидуальных условий.';


	/**
	 * Переменные для тестирования API идентификации, требуются для выполнения тестов.
	 * логин и пароль должны соответствовать заданным в IdentifyModuleTest
	 */
	private $testLogin = '9631321654';
	private $testPassword = 'Aa123456';
	private $testToken = 'abcdsdg*98ughjg23t8742yusdjf';

	const C_NEED_PASSPORT_DATA = "ВНИМАНИЕ! Идентификация пройдена, но форма подтверждения документов не заполнена. Для продолжения {passport_url_start}заполни, пожалуйста, форму{passport_url_end}.";

	private $token;
	private $aClientInfo; //массив с данными клиента
	private $iLastCode; //code из последнего выполненного запроса
	private $sLastMessage = ''; //message из последнего выполненного запроса
	private $sLastSmsMessage = ''; //sms_message из последнего выполненного запроса
	private $bIsCanSubscribe = null; //клиент может оформить подписку
	private $bIsCanGetLoan = null; //клиент может взять заём
	private $iScoringResult = null;
	private $aCheckIdentify;
	private $bIsNeedCard;

	public $sApiUrl = '';
	public $sTestApiUrl = '';
	private $iSmsCode;
	private $oCardVerifyStatus;

	/**
	 * Заменяет в сообщениях Клиенту шаблоны на вычисляемые значения
	 * TODO найти все использования не для статусов, сделать для них отдельный форматтер
	 *
	 * @return array
	 */
	public function formatStatusMessage()
	{
		// берём ID продукта из сессии, если есть
		/*$iProductId = $this->getSubscribeSelectedProductId();
		if (!$iProductId) {
			// если нет в сессии - из ответа API
			$iProductId = $this->getSubscriptionProductId();
		}*/

		Yii::app()->adminKreddyApi->getSubscribeProductCost();

		return array(
			'{sub_pay_sum}'        => $this->getSubscriptionCost(), // стоимость подключения текущего пакета

			'{do_sub_pay_sum}'     => $this->getSubscribeProductCost(), //стоимость оформляемого в данный момент пакета

			'{loan_amount}'        => $this->getSubscriptionLoanAmount(), // сумма займа

			'{channel_name}'       => SiteParams::mb_lcfirst($this->getChannelNameForSubscriptionLoan($this->getLoanSelectedChannel())), // название канала

			'{account_url_start}'  => CHtml::openTag("a", array(
					"href" => Yii::app()->createUrl("/account")
				)), // ссылка на инфо о пакете
			'{account_url_end}'    => CHtml::closeTag("a"), // /ссылка на инфо о пакете

			'{do_loan_url_start}'  => CHtml::openTag("a", array(
					"href" => Yii::app()->createUrl("/account/loan")
				)), // ссылка на получение займа
			'{do_loan_url_end}'    => CHtml::closeTag("a"), // /ссылка на получение займа

			'{payments_url_start}' => CHtml::openTag("a", array(
					"href" => Yii::app()->createUrl("pages/view/payments"), "target" => "_blank"
				)), // ссылка на инфо о возможных вариантах оплаты
			'{payments_url_end}'   => CHtml::closeTag("a"), // /ссылка на инфо о возможных вариантах оплаты

			'{contacts_url_start}' => CHtml::openTag("a",
					array("href" => "#fl-contacts", "data-target" => "#fl-contacts", "data-toggle" => "modal")), // ссылка на инфо об отделении
			'{contacts_url_end}'   => CHtml::closeTag("a"), // /ссылка на инфо об отделении
			'{loan_transfer_time}' => $this->getLoanChannelSpeed($this->getLoanSelectedChannel())
		);
	}

	/**
	 * Форматирование сообщения по шаблону
	 *
	 * @param $sMessage
	 *
	 * @return string
	 */
	public function formatMessage($sMessage)
	{
		$aReplace = array(
			'{passport_url_start}' => CHtml::openTag("a", array(
					"href" => Yii::app()->createUrl("/account/changePassport"),
				)), // ссылка на форму изменения паспорта
			'{passport_url_end}'   => CHtml::closeTag("a")
		);

		return strtr($sMessage, $aReplace);
	}

	/**
	 * @return array
	 */
	public function attributeNames()
	{
		return array('token' => 'Token');
	}

	/**
	 * При инициализации обязательно требуется запросить обновление токена
	 */
	public function init()
	{
		$this->token = $this->getSessionToken();
		if (!empty($this->token)) {
			//если токен существует, то запрашиваем его обновление
			$this->updateClientToken();
		}
	}

	/**
	 * @return bool
	 */
	public function isLoggedIn()
	{
		return isset($this->token);
	}

	/**
	 * Авторизация в API по логину и паролю, получаем токен и сохраняем в сессию
	 *
	 * @param $sPhone
	 * @param $sPassword
	 *
	 * @return bool
	 */
	public function getAuth($sPhone, $sPassword)
	{

		$aRequest = array(
			'login'       => $sPhone,
			'password'    => $sPassword,
			'ip'          => Yii::app()->request->getUserHostAddress(),
			'site_region' => Yii::app()->clientForm->getSiteRegionId(),
		);

		$aTokenData = $this->requestAdminKreddyApi(self::API_ACTION_TOKEN_CREATE, $aRequest);

		if ($aTokenData['code'] === self::ERROR_NONE) {
			$this->setSessionToken($aTokenData['token']);
			$this->token = $aTokenData['token'];

			//перезапросим инфо клиента
			$this->getClientInfo(true);

			// Если смс-авторизация не требутеся
			if (!$this->getIsNeedSmsAuth()) {
				$this->setSmsAuthDone(true);
			} else {
				$this->setSmsAuthDone(false);
			}

			if ($this->checkIsNeedPassportData()) {
				Yii::app()->user->setFlash('warning', $this->formatMessage(self::C_NEED_PASSPORT_DATA));
			}

			return true;
		}

		return false;
	}

	/**
	 * * Метод для получения авторизации и токена для API идентификации
	 *
	 * @param      $sPhone
	 * @param      $sPassword
	 *
	 * @param bool $bTest
	 *
	 * @return null|string
	 */
	public function getIdentifyApiAuth($sPhone, $sPassword, $bTest = false)
	{
		$aRequest = array('login' => $sPhone, 'password' => $sPassword);

		if ($bTest && $this->testLogin == $sPhone && $this->testPassword == $sPassword) {
			return $this->testToken;
		}

		//проверяем, не исчерпаны ли попытки авторизации
		if (!AntiBotComponent::isCanLoginRequest()) {
			return null;
		}

		//добавляем в лог запись о еще одном запросе на авторизацию
		AntiBotComponent::addLoginRequest();

		$aTokenData = $this->requestAdminKreddyApi(self::API_ACTION_TOKEN_CREATE, $aRequest);
		if ($aTokenData['code'] === self::ERROR_NONE) {

			return $aTokenData['token'];
		}

		return null;
	}

	/**
	 * @param      $oCurlFile
	 * @param      $sDocumentType
	 * @param      $sToken
	 *
	 * @param bool $bTest
	 *
	 * @return bool
	 */
	public function uploadDocument($oCurlFile, $sDocumentType, $sToken, $bTest = false)
	{
		$aRequest = array(
			'token' => $sToken, 'type' => $sDocumentType,
			'files' => $oCurlFile,
		);

		if ($bTest && $sToken == $this->testToken) {
			return true;
		}

		$aResponse = $this->requestAdminKreddyApi(self::API_ACTION_UPLOAD_DOCUMENT, $aRequest);
		if ($aResponse['code'] === self::ERROR_NONE) {

			return true;
		}

		return false;
	}

	/**
	 * @param      $sToken
	 *
	 * @param bool $bTest
	 *
	 * @return bool
	 */
	public function setFinishedVideoId($sToken, $bTest = false)
	{
		if ($bTest && $sToken == $this->testToken) {
			return true;
		}

		$aRequest = array(
			'token' => $sToken,
		);

		$aResponse = $this->requestAdminKreddyApi(self::API_ACTION_SET_IDENTIFICATION_FINISHED, $aRequest);
		if ($aResponse['code'] === self::ERROR_NONE) {

			return true;
		}

		return false;
	}

	/**
	 * @param $aClientData
	 *
	 * @return bool
	 */
	public function createClient($aClientData)
	{
		$aRequiredFields = array(
			'tracking_id'         => null,
			'ip'                  => null,

			'last_name'           => null,
			'first_name'          => null,
			'third_name'          => null,
			'sex'                 => null,
			'prev_last_name'      => null,
			'birthday'            => null,
			'phone'               => null,
			'email'               => null,

			'passport_series'     => null,
			'passport_number'     => null,
			'passport_date'       => null,
			'passport_code'       => null,
			'passport_issued'     => null,

			'document'            => null,
			'document_number'     => null,

			'relatives_one_fio'   => null,
			'relatives_one_phone' => null,

			'address_reg_region'  => null,
			'address_reg_city'    => null,
			'address_reg_address' => null,

			'address_reg_as_res'  => null,

			'address_res_region'  => null,
			'address_res_city'    => null,
			'address_res_address' => null,

			'numeric_code'        => null,

			'secret_question'     => null,
			'secret_answer'       => null,

			'status'              => null,
			'loan_purpose'        => null,
			'birthplace'          => null,
			'password'            => null,
		);

		$sDateFormatInBase = "Y-m-d";
		$aClientData['birthday'] = date($sDateFormatInBase, strtotime($aClientData['birthday']));
		$aClientData['passport_date'] = date($sDateFormatInBase, strtotime($aClientData['passport_date']));

		$aClientData = array_intersect_key($aClientData, $aRequiredFields);

		$aRequest = array('clientData' => CJSON::encode($aClientData));
		$aTokenData = $this->requestAdminKreddyApi(self::API_ACTION_CREATE_CLIENT, $aRequest);

		if (!self::getIsError() && !self::getIsClientExistsError()) {
			$this->setSessionToken($aTokenData['token']);
			$this->token = $aTokenData['token'];
			$this->setSmsAuthDone(true);

			return true;
		}

		return false;
	}

	/**
	 * @param $aClientData
	 *
	 * @return bool
	 */
	public function createFastRegClient($aClientData)
	{
		//список полей, которые требуется передать при быстрой регистрации
		$aRequiredFields = array(
			'first_name'  => null,
			'last_name'   => null,
			'third_name'  => null,
			'email'       => null,
			'phone'       => null,
			'birthday'    => null,
			'tracking_id' => null,
			'ip'          => null,
			'site_region' => null,
		);


		if (!empty($aClientData['sex'])) {
			$aRequiredFields['sex'] = null;
		}

		//получаем массив, соджержащий только заданные поля
		$aClientData = array_intersect_key($aClientData, $aRequiredFields);


		$aRequest = array('clientData' => CJSON::encode($aClientData));
		$aTokenData = $this->requestAdminKreddyApi(self::API_ACTION_CREATE_FAST_REG_CLIENT, $aRequest);

		if (!self::getIsError() && !self::getIsClientExistsError()) {
			$this->setSessionToken($aTokenData['token']);
			$this->token = $aTokenData['token'];
			$this->setSmsAuthDone(true);

			return true;
		}

		return false;
	}

	/**
	 * Регистрация клиента через TornadoApi
	 *
	 * @param $aClientData
	 *
	 * @return bool|string
	 */
	public function createTornadoApiClient($aClientData)
	{
		//список полей, которые требуется передать при быстрой регистрации
		$aRequiredFields = array(
			'first_name'  => null,
			'last_name'   => null,
			'third_name'  => null,
			'email'       => null,
			'phone'       => null,
			'birthday'    => null,
			'tracking_id' => null,
			'ip'          => null,
			'site_region' => null,
		);

		//получаем массив, соджержащий только заданные поля
		$aClientData = array_intersect_key($aClientData, $aRequiredFields);

		$aRequest = array('clientData' => CJSON::encode($aClientData));
		$aTokenData = $this->requestAdminKreddyApi(self::API_ACTION_CREATE_FAST_REG_CLIENT, $aRequest);

		if (!self::getIsError() && !self::getIsClientExistsError()) {
			return $aTokenData['token'];
		}

		return false;
	}

	/**
	 * @param $aClientData
	 *
	 * @return bool
	 */
	public function updateFastRegClient($aClientData)
	{
		//список полей, которые требуется передать при обновлении анкеты быстрой регистрации
		$aRequiredFields = array(
			'last_name'           => null,
			'first_name'          => null,
			'third_name'          => null,
			'sex'                 => null,
			'prev_last_name'      => null,
			'birthday'            => null,

			'passport_series'     => null,
			'passport_number'     => null,
			'passport_date'       => null,
			'passport_code'       => null,
			'passport_issued'     => null,

			'document'            => null,
			'document_number'     => null,

			'relatives_one_fio'   => null,
			'relatives_one_phone' => null,

			'address_reg_region'  => null,
			'address_reg_city'    => null,
			'address_reg_address' => null,

			'address_res_region'  => null,
			'address_res_city'    => null,
			'address_res_address' => null,

			'numeric_code'        => null,

			'secret_question'     => null,
			'secret_answer'       => null,

			'status'              => null,

			'loan_purpose'        => null,
			'birthplace'          => null,

			'order_id'            => null,
		);

		//получаем массив, соджержащий только заданные поля
		$aClientData = array_intersect_key($aClientData, $aRequiredFields);

		$sDateFormatInBase = "Y-m-d";
		$aClientData['birthday'] = date($sDateFormatInBase, strtotime($aClientData['birthday']));
		$aClientData['passport_date'] = date($sDateFormatInBase, strtotime($aClientData['passport_date']));

		$aRequest = array('clientData' => CJSON::encode($aClientData));
		$this->requestAdminKreddyApi(self::API_ACTION_UPDATE_FAST_REG_CLIENT, $aRequest);

		if (!self::getIsError()) {

			return true;
		}

		return false;
	}

	/**
	 * Обновляем токен, обязательно выполняется при инициализации компонента
	 *
	 * @return bool
	 */
	protected function updateClientToken()
	{
		//отсылаем текущий токен и получаем новый токен в ответ, обновляем его в сессии

		$aRequest = array('token' => $this->getSessionToken());

		$aTokenData = $this->requestAdminKreddyApi(self::API_ACTION_TOKEN_UPDATE, $aRequest);
		if ($aTokenData['code'] == self::ERROR_NONE) {
			$this->setSessionToken($aTokenData['token']);
			$this->token = $aTokenData['token'];

			return true;
		}

		if (($aTokenData['code'] == self::ERROR_TOKEN_EXPIRE)) {
			$this->setUserSessionExpired();
		}

		$this->setSessionToken(null);
		$this->token = null;

		return false;
	}

	/**
	 * Метод для обновления токена для API идентификации
	 *
	 * @param      $sToken
	 *
	 * @param bool $bTest
	 *
	 * @return null
	 */
	public function updateIdentifyApiToken($sToken, $bTest = false)
	{
		$aRequest = array('token' => $sToken);

		if ($bTest && $sToken == $this->testToken) {
			return $this->testToken;
		}

		$aTokenData = $this->requestAdminKreddyApi(self::API_ACTION_TOKEN_UPDATE, $aRequest);

		if ($aTokenData['code'] == self::ERROR_NONE) {
			return $aTokenData['token'];
		}

		return null;
	}

	/**
	 * Запрос от API СМС-кода для подтверждения восстановления пароля
	 *
	 * @param array $aData
	 * @param bool  $bResend
	 *
	 * @return bool
	 */
	public function resetPasswordSendSms(array $aData, $bResend = false)
	{
		return $this->doSendSms(self::API_ACTION_RESET_PASSWORD, $aData, $bResend);
	}

	/**
	 * Проверка СМС-кода для подтверждения восстановления пароля
	 *
	 * @param array $aData
	 *
	 * @return string|bool
	 */
	public function resetPasswordCheckSms(array $aData)
	{
		$sSmsCode = $aData['sms_code'];

		return $this->doCheckSms(self::API_ACTION_RESET_PASSWORD, $sSmsCode, $aData);
	}

	/**
	 * Получение основной информации о клиенте в виде массива
	 *
	 * @param bool $bForce //сделать force-запрос к API без использования кэша
	 *
	 * @return array|bool
	 */
	public function getClientInfo($bForce = false)
	{
		//если данные уже были сохранены - возвращаем их без повторного запроса
		if (isset($this->aClientInfo) && !$bForce) {
			return $this->aClientInfo;
		}

		//TODO сравнить с текущей выдачей API и дополнить пустые массивы новыми ключами
		$aData = array(
			'code'                   => self::ERROR_AUTH,
			'client_data'            => array(
				'is_debt'               => false,
				'fullname'              => '',
				'client_new'            => false,
				'sms_auth_enabled'      => false,
				'is_possible_take_loan' => false,
			),
			'status'                 => array(
				'name' => false,
			),
			'loan_request'           => false,
			'first_identification'   => false,
			'current_client_product' => array(
				'channel_id'              => false,
				'subscription_expired'    => false,
				'subscription_expired_to' => false,
				'loan_expired'            => false,
				'loan_expired_to'         => false,
				'balance'                 => 0,
				'loan_balance'            => 0,
				'subscription_balance'    => 0,
				'fine_balance'            => 0,
				'penalty_balance'         => 0,
				'percent_balance'         => 0,
				'percent_daily'           => 0,
				'loan_days_usage'         => 0,
			),
			'subscription_request'   => array(
				'name'       => false,
				'can_cancel' => false,
				'type'       => 0
			),
			'subscription'           => array(
				'product'         => false,
				'product_id'      => false,
				'activity_to'     => false,
				'channel_id'      => false,
				'available_loans' => 0,
				'balance'         => 0,
				'product_info'    => array(
					'channels'      => array(),
					'loan_amount'   => false,
					'loan_lifetime' => false,
					'type'          => false,
				),
			),
			'moratoriums'            => array(
				'loan'         => false,
				'subscription' => false,
				'scoring'      => false,
			),
			'channels'               => array(),
			'slow_channels'          => array(),
			'bank_card_exists'       => false,
			'bank_card_expired'      => false,
			'bank_card_pan'          => false,
		);
		$this->token = $this->getSessionToken();
		if (!empty($this->token)) {
			//запрос данных по токену
			$aGetData = $this->getData('info');

			if (is_array($aGetData)) {
				$aData = CMap::mergeArray($aData, $aGetData);
			}
		}

		$this->processNewClientInfo($aData);

		return $aData;
	}

	/**
	 * После получения новой информации о клиенте следует обработать информацию
	 * и соответствующим образом отреагировать на нее
	 *
	 * @param $aData
	 */
	protected function processNewClientInfo($aData)
	{
		//сохраняем полученные данные для последующих запросов
		$this->aClientInfo = $aData;

		//запрашиваем, ушел ли клиент на идентификацию
		$bClientOnIdentify = $this->getClientOnIdentify();
		//если клиент ушел на идентификацию
		//проверяем, требуется ли заново ввести паспортные данные
		if ($bClientOnIdentify && $this->checkIsNeedPassportData()) {
			//выводим сообщение о необходимости повторно ввести паспортные данные
			Yii::app()->user->setFlash('warning', $this->formatMessage(self::C_NEED_PASSPORT_DATA));
		}

		//если не авторизован, то незачем ставить warning'и, а то они потом вылезут после авторизации
		if (!Yii::app()->adminKreddyApi->getIsAuth()) {
			return;
		}

		//если нет привязанной карты и не установлен другой warning, то уведомляем о необходимости привязки карты
		if (Yii::app()->user->hasFlash('warning')) {
			return;
		}

		if ($aData['bank_card_expired'] === true) {
			Yii::app()->user->setFlash('warning', self::C_CARD_WARNING_EXPIRED);
		} elseif ($aData['bank_card_exists'] === false) {
			Yii::app()->user->setFlash('warning', self::C_CARD_WARNING_NO_CARD);
		}

		return;
	}

	/**
	 * @return bool
	 */
	public function getIsNewClient()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['client_data']['client_new'];
	}

	public function getIsCanCancelRequest()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription_request']['can_cancel'];
	}

	/**
	 * Получаем массив с каналами, доступными клиенту
	 * array('kreddy','mobile')
	 *
	 * @return array
	 */
	public function getClientChannels()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['channels'];
	}

	/**
	 * @param $iChannelId
	 *
	 * @return bool
	 */
	public function getIsSlowChannel($iChannelId)
	{
		$aClientInfo = $this->getClientInfo();

		return in_array($iChannelId, $aClientInfo['slow_channels']);
	}

	/**
	 * @param $iChannelId
	 *
	 * @return string
	 */
	public function getChannelSpeed($iChannelId)
	{
		return ($this->getIsSlowChannel($iChannelId)) ? "до 3 дней" : "несколько минут";
	}

	/**
	 * То же, что и выше, для сообщения об успешном получении займа
	 *
	 * @param $iChannelId
	 *
	 * @return string
	 */
	public function getLoanChannelSpeed($iChannelId)
	{
		return ($this->getIsSlowChannel($iChannelId)) ? "в течение 3 дней." : "в течение нескольких минут.";
	}

	/**
	 * Получаем массив с каналами, доступными клиенту по данной подписке
	 * array('kreddy','mobile')
	 *
	 * @return array
	 */
	public function getClientSubscriptionChannels()
	{
		$aClientInfo = $this->getClientInfo();

		//находим пересечение массивов, т.е. каналы, которые доступны пользователю, и при этом доступные для текущей подписки
		$aChannels = array_intersect($aClientInfo['subscription']['product_info']['channels'], $aClientInfo['channels']);

		return $aChannels;
	}

	/**
	 * Получаем имя канала по его id
	 *
	 * @param $iChannel
	 *
	 * @return string|bool
	 */
	public function getChannelNameById($iChannel)
	{
		$aChannels = $this->getProductsChannels();

		return (isset($aChannels[$iChannel])) ? $aChannels[$iChannel] : false;
	}

	/**
	 * @param $iChannel
	 *
	 * @return bool|mixed|string
	 */
	public function getChannelNameForSubscriptionLoan($iChannel)
	{
		$sChannelName = $this->getChannelNameById($iChannel);

		$sChannelName = preg_replace('/Перевод /ui', '', $sChannelName);

		return $sChannelName;
	}

	/**
	 * Отдает имя канала для статуса, в случае если статусное сообщение - "Деньги отправлены"
	 *
	 * @return bool|string
	 */
	public function getChannelNameForStatus()
	{
		$sStatusName = $this->getClientStatus();
		$aStatuses = array(
			self::C_LOAN_ACTIVE,
			self::C_LOAN_TRANSFER,
			self::C_LOAN_CREATED,
		);
		//проверяем, что текущий статус находится в списке статусов, для которых нужно выдать имя канала
		if (in_array($sStatusName, $aStatuses)) {
			$iActiveLoanChannelId = Yii::app()->adminKreddyApi->getSubscriptionChannelId();
			$sChannelName = Yii::app()->productsChannels->formatChannelNameForStatus(Yii::app()->adminKreddyApi->getChannelNameById($iActiveLoanChannelId));

		} else {
			$sChannelName = '';
		}

		return $sChannelName;
	}

	/**
	 * Получение сообщения статуса (активен, в скоринге, ожидает оплаты)
	 *
	 * @return string|bool
	 */
	public function getStatusMessage()
	{

		$sStatusName = $this->getClientStatus();

		if (!SiteParams::getIsIvanovoSite()) {
			$sStatus = (!empty($this->aAvailableStatuses[$sStatusName])) ? $this->aAvailableStatuses[$sStatusName] : self::C_STATUS_ERROR;
		} else {
			$sStatus = (!empty($this->aAvailableStatusesIvanovo[$sStatusName])) ? $this->aAvailableStatusesIvanovo[$sStatusName] : self::C_STATUS_ERROR;
		}

		$sStatus = strtr($sStatus, $this->formatStatusMessage());

		return $sStatus;
	}

	/**
	 * @return string
	 */
	public function getClientStatus()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['status']['name'];
	}

	/**
	 * @return bool
	 */
	public function isFastReg()
	{
		$cStatus = $this->getClientStatus();
		if ($cStatus == self::C_CLIENT_FAST_REG) {
			return true;
		}

		return false;
	}

	/**
	 * Получение баланса
	 *
	 * @return int
	 */
	public function getBalance()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['current_client_product']['balance'];
	}

	/**
	 * Получение абсолютного значения баланса
	 *
	 * @return int|number
	 */
	public function getAbsBalance()
	{
		$aClientInfo = $this->getClientInfo();

		return abs($aClientInfo['current_client_product']['balance']);
	}

	/**
	 * @return number
	 */
	public function getAbsLoanBalance()
	{
		$aClientInfo = $this->getClientInfo();

		return abs($aClientInfo['current_client_product']['loan_balance']);
	}

	/**
	 * @return number
	 */
	public function getAbsSubscriptionBalance()
	{
		$aClientInfo = $this->getClientInfo();

		return abs($aClientInfo['current_client_product']['subscription_balance']);
	}

	/**
	 * @return number
	 */
	public function getAbsFine()
	{
		$aClientInfo = $this->getClientInfo();

		return abs($aClientInfo['current_client_product']['fine_balance']);
	}

	/**
	 * @return number
	 */
	public function getAbsPenalty()
	{
		$aClientInfo = $this->getClientInfo();

		return abs($aClientInfo['current_client_product']['penalty_balance']);
	}

	/**
	 * @return number
	 */
	public function getAbsPercent()
	{
		$aClientInfo = $this->getClientInfo();

		return abs($aClientInfo['current_client_product']['percent_balance']);
	}

	/**
	 * @return bool|string
	 */
	public function getSubscriptionRequestName()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription_request']['name'];
	}

	/**
	 * @return int
	 */
	public function getSubscriptionRequestType()
	{
		$aClientInfo = $this->getClientInfo(true);

		return $aClientInfo['subscription_request']['type'];
	}


	/**
	 * Получаем сумму из имени пакета, не работает для пакетов типа "Покупки", использовать только для Иваново
	 *
	 * @return bool|string
	 */
	public function getSubscriptionRequestLoan()
	{

		$sProduct = $this->getSubscriptionRequestName();
		$iProductLoan = preg_replace('/[^\d]+/', '', $sProduct);

		return ($iProductLoan) ? $iProductLoan : false;
	}

	/**
	 * ID канала текущей подписки
	 *
	 * @return bool
	 */
	public function getSubscriptionChannelId()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['current_client_product']['channel_id'];
	}

	/**
	 * @return bool|string
	 */
	public function getSubscriptionProduct()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription']['product'];
	}

	/**
	 * Получить тип продукта
	 *
	 * @return string
	 */
	public function getProductType()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription']['product_info']['type'];
	}

	/**
	 * Проверяем, является ли текущая подписка "старой", т.е. на старые продукты до КРЕДДИтной линии
	 *
	 * @return bool
	 */
	public function isSubscriptionOldType()
	{
		$sType = $this->getProductType();

		switch ($sType) {
			case self::PRODUCT_TYPE_KREDDY:
			case self::PRODUCT_TYPE_IVANOVO:
				return true;
				break;
			default:
				return false;
				break;
		}

	}

	/**
	 * @return bool|string
	 */
	public function getSubscriptionChannel()
	{
		$aClientInfo = $this->getClientInfo();

		$iChannelId = $aClientInfo['subscription']['channel_id'];

		return $this->getChannelNameById($iChannelId);
	}

	/**
	 * Стоимость текущей подписки клиента из getInfo
	 *
	 * @return bool
	 *
	 */
	public function getSubscriptionCost()
	{
		$aClientInfo = $this->getClientInfo();

		$iSubscriptionCost = $aClientInfo['subscription']['balance'];

		if ($iSubscriptionCost > 0) {
			$iSubscriptionCost = 0;
		} elseif ($iSubscriptionCost < 0) {
			$iSubscriptionCost *= -1;
		}

		return $iSubscriptionCost;

	}

	/**
	 * @return bool|string
	 */
	public function getSubscriptionLoanAmount()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription']['product_info']['loan_amount'];
	}

	/**
	 * @return bool|string
	 */
	public function getSubscriptionLoanLifetime()
	{
		$aClientInfo = $this->getClientInfo();

		$oCurrTime = new DateTime();
		$oCurrTime->setTimestamp(SiteParams::getTime());

		$oExpiredTime = new DateTime();
		$oExpiredTime->setTimestamp(SiteParams::strtotime($aClientInfo['subscription']['activity_to']));

		$oDateInterval = $oCurrTime->diff($oExpiredTime);

		return $oDateInterval->days;
	}

	/**
	 * @return bool|string
	 */
	public function getSubscriptionProductId()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription']['product_id'];
	}

	/**
	 * @return string|bool
	 */
	public function getSubscriptionActivity()
	{
		if ($this->isSubscriptionAwaitingConfirmationStatus()) {
			return false;
		}

		$aClientInfo = $this->getClientInfo();
		$sActivityTo = $aClientInfo['subscription']['activity_to'];
		$sActivityTo = SiteParams::formatRusDate($sActivityTo);

		return $sActivityTo;
	}

	/**
	 * @return string|bool
	 */
	public function getSubscriptionActivityToTime()
	{
		$aClientInfo = $this->getClientInfo();
		if ($aClientInfo['subscription']['activity_to']) {
			$sActivityTo = $aClientInfo['subscription']['activity_to'];
			$sActivityTo = SiteParams::formatRusDate($sActivityTo, true);

			return $sActivityTo;
		}

		return false;

	}

	/**
	 * @return int|number
	 */
	public function getSubscriptionAvailableLoans()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription']['available_loans'];
	}

	/**
	 * Возвращает PAN карты, если она привязана
	 *
	 * @return bool
	 */
	public function getBankCardPan()
	{
		$aClientInfo = $this->getClientInfo();

		return ($aClientInfo['bank_card_exists'] && $aClientInfo['bank_card_pan'])
			? $aClientInfo['bank_card_pan']
			: false;
	}

	/**
	 * Возвращает дату окончания моратория на заём, если такой мораторий есть
	 *
	 * @return bool|string
	 */
	public function getMoratoriumLoan()
	{
		$aClientInfo = $this->getClientInfo();
		$sMoratoriumTo = $aClientInfo['moratoriums']['loan'];
		$sMoratoriumTo = SiteParams::formatRusDate($sMoratoriumTo, false);

		return $sMoratoriumTo;
	}

	/**
	 * Сравнивает 2 даты и возвращает бОльшую
	 *
	 * @param string $sDate1
	 * @param string $sDate2
	 *
	 * @return string
	 */
	private function getMaxDateInFormat($sDate1, $sDate2)
	{
		$iDate1 = strtotime($sDate1);
		$iDate2 = strtotime($sDate2);

		$iMaxDate = ($iDate1 > $iDate2) ? $iDate1 : $iDate2;

		return SiteParams::formatRusDate($iMaxDate, false);
	}

	/**
	 * Возвращает дату окончания моратория на заём (выбирая максимум между мораториями на подписку и скоринг),
	 * если такой мораторий есть
	 *
	 * @return bool|string
	 */
	public function getMoratoriumSubscription()
	{
		$aClientInfo = $this->getClientInfo();

		$sMoratoriumSub = $aClientInfo['moratoriums']['subscription'];
		$sMoratoriumScoring = $aClientInfo['moratoriums']['scoring'];

		$sMoratoriumTo = $this->getMaxDateInFormat($sMoratoriumSub, $sMoratoriumScoring);

		return $sMoratoriumTo;
	}

	/**
	 * Возвращает дату окончания моратория на заём (выбирая максимум между мораториями на подписку, скоринг и заём),
	 * если такой мораторий есть
	 *
	 * @return bool|string
	 */
	public function getMoratoriumSubscriptionLoan()
	{
		$aClientInfo = $this->getClientInfo();

		$sMoratoriumLoan = $aClientInfo['moratoriums']['loan'];

		$sMoratoriumTo = $this->getMaxDateInFormat($this->getMoratoriumSubscription(), $sMoratoriumLoan);

		return $sMoratoriumTo;
	}

	/**
	 * @return bool
	 */
	public function isSubscriptionAwaitingConfirmationStatus()
	{
		return $this->getClientStatus() == AdminKreddyApiComponent::C_SUBSCRIPTION_AWAITING_CONFIRMATION;
	}

	/**
	 * @return bool
	 */
	public function getCurrentProductExpired()
	{
		if ($this->isSubscriptionAwaitingConfirmationStatus()) {
			return false;
		}
		$aClientInfo = $this->getClientInfo();
		$bExpired = $aClientInfo['current_client_product']['loan_expired'] || $aClientInfo['current_client_product']['subscription_expired'];

		return $bExpired;
	}

	/**
	 * @return bool|string
	 */
	public function getCurrentProductLoanExpiredTo()
	{
		if ($this->isSubscriptionAwaitingConfirmationStatus()) {
			return false;
		}

		$aClientInfo = $this->getClientInfo();

		$sExpiredTo = $aClientInfo['current_client_product']['loan_expired_to'];

		if ($sExpiredTo == SiteParams::EMPTY_DATETIME) {
			return false;
		}

		$sExpiredTo = SiteParams::formatRusDate($sExpiredTo);

		return $sExpiredTo;
	}

	public function getCurrentClientProduct()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['current_client_product'];
	}

	/**
	 * Получение полного имени клиента
	 *
	 * @return string
	 */
	public function getClientFullName()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['client_data']['fullname'];
	}

	/**
	 * Получение данных клиента в статусе "быстрая регистрация", заполненных оператором КЦ
	 *
	 * @return array
	 */
	public function getFullClientData()
	{
		$aClientData = $this->getData('full_data');

		return isset($aClientData['client_data']) ? $aClientData['client_data'] : array();
	}

	/**
	 * Есть ли у клиента задолженность по кредиту
	 *
	 * @return bool
	 */
	public function getIsDebt()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['client_data']['is_debt'];
	}

	/**
	 * Получение истории операций в виде массива
	 *
	 * @return array
	 */
	public function getHistory()
	{
		$aData = array('code' => self::ERROR_AUTH);
		if (!empty($this->token)) {
			//тут типа запрос данных по токену
			$aGetData = $this->getData('history');

			$aData = array_merge($aData, $aGetData);
		}

		return $aData;
	}

	/**
	 * Сортировщик для истории операций
	 *
	 * @return CSort
	 */
	private function getHistorySort()
	{
		$sort = new CSort;
		$sort->defaultOrder = 'time DESC';
		$sort->attributes = array('time', 'type', 'type_id', 'amount');

		return $sort;
	}

	/**
	 * DataProvider для истории операций
	 *
	 * @return \CArrayDataProvider
	 */
	public function getHistoryDataProvider()
	{
		$aHistory = $this->getHistory();
		if (isset($aHistory) && $aHistory['code'] === 0 && isset($aHistory['history'])) {
			$oHistoryDataProvider = new CArrayDataProvider($aHistory['history'],
				array(
					'keyField' => 'time',
					'sort'     => $this->getHistorySort()
				)
			);
		} else {
			$oHistoryDataProvider = new CArrayDataProvider(array());
		}

		return $oHistoryDataProvider;
	}

	/**
	 * Получение массива с информацией о продуктах и каналах
	 *
	 * @return array
	 */
	public function getProductsAndChannels()
	{
		if (SiteParams::getIsIvanovoSite()) {
			$sCacheName = 'productsAndChannelsIvanovo';
		} else {
			$sCacheName = 'productsAndChannels';
		}


		$aProducts = Yii::app()->cache->get($sCacheName);

		if (!empty($aProducts)) {
			return $aProducts;
		}

		$aProductsAndChannels = $this->getData('products_and_channels');

		if ($aProductsAndChannels['code'] === self::ERROR_NONE) {
			//сохраняем в кэш с временем хранения 10 минут
			Yii::app()->cache->set($sCacheName, $aProductsAndChannels, 600);
			//кэш длительного хранения, на случай отключения API
			Yii::app()->cache->set($sCacheName . 'LongTime', $aProductsAndChannels);

		} else {
			//если вдруг при обращении к API вылезла ошибка, достаем данные из длительного кэша

			$aProducts = Yii::app()->cache->get($sCacheName . 'LongTime');
			if (isset($aProducts)) {
				return $aProducts;
			}
		}

		return $aProductsAndChannels;
	}

	/**
	 * @param bool $bPostPaid
	 * @param bool $bPrePaid
	 *
	 * @return array
	 */
	public function getClientProductsList($bPostPaid = true, $bPrePaid = true)
	{
		//получаем список продуктов
		$aProducts = $this->getProducts();
		//получаем список каналов
		$aChannels = $this->getProductsChannels();
		//получаем список каналов, доступных клиенту
		$aClientChannels = $this->getClientChannels();
		$aAvailableProducts = array();
		//проверяем, что получили массивы
		if (is_array($aProducts) && is_array($aChannels) && is_array($aClientChannels)) {

			//перебираем все продукты
			foreach ($aProducts as $aProduct) {
				//Если тип продукта - постоплата и нам не нужны пост-оплатные продукты - пропускаем
				if (in_array($aProduct['type'], self::$aPostPaidProducts) && !$bPostPaid) {
					continue;
				}
				//Если тип продукта - не постоплата (предоплата) и нам не нужны предоплатные продукты - пропускаем
				if (!in_array($aProduct['type'], self::$aPostPaidProducts) && !$bPrePaid) {
					continue;
				}

				//получаем из продукта каналы, по которым его можно получить
				$aProductChannels = (isset($aProduct['channels']) && is_array($aProduct['channels']))
					? $aProduct['channels']
					: array();
				//перебираем каналы, по которым можно получить продукт
				foreach ($aProductChannels as $iKey => $aChannel) {
					//проверяем, что у канала есть описание
					//проверяем, что данный канал доступен пользователю
					if (isset($aChannels[$iKey])
						&& in_array($iKey, $aClientChannels)
					) {
						$aAvailableProducts[$aProduct['id']] = $aProduct['loan_amount'];
					}
				}
			}
		}

		return $aAvailableProducts;
	}

	/**
	 * Заполняет массив значений доступных каналов соответствующими id канала
	 *
	 * @return array
	 */
	public function getAvailableChannelValues()
	{
		// по умолчанию ставим false, т.е. что каналы недоступны
		$aAvailableChannelValues = array(
			self::C_CARD   => false,
			self::C_MOBILE => false,
		);

		$bIsSecondLoan = $this->getSubscriptionProductId();
		if ($bIsSecondLoan) {
			// если повторный займ - соответственно, берём каналы, доступные по текущей подписке.
			$aAvailableChannelKeys = $this->getClientSubscriptionChannels();
		} else {
			// иначе берём каналы, доступные по выбранному на предыдущем шаге формы Пакету
			$aAvailableChannelKeys = $this->getSelectedProductChannelsList();
		}

		$aAllChannelNames = $this->getProductsChannels();
		foreach (self::$aChannels as $sChannel) {
			$sRegexp = self::$aChannelsRegexps[$sChannel];

			// перебираем все доступные Клиенту каналы
			foreach ($aAvailableChannelKeys as $sKey) {
				// берём соответствующее имя из массива имён каналов
				$sAvailableChannelName = $aAllChannelNames[$sKey];

				// ищем совпадению по регулярному выражению. в случае успеха - записываем id канала на место false
				// например: $aAvailableChannelValues['card'] = 20;
				if (preg_match($sRegexp, $sAvailableChannelName)) {
					$aAvailableChannelValues[$sChannel] = $sKey;
					break;
				}
			}
		}

		return $aAvailableChannelValues;
	}

	/**
	 * Получение массива с информацией о продуктах
	 *
	 * @return array|bool
	 */
	public function getProducts()
	{
		$aProducts = $this->getProductsAndChannels();

		if (isset($aProducts['products'])) {

			return $aProducts['products'];
		}

		return false;
	}

	/**
	 * Получение массива с информацией о каналах
	 *
	 * @return array|bool
	 */
	public function getProductsChannels()
	{
		$aProducts = $this->getProductsAndChannels();

		if (isset($aProducts['channels'])) {

			return $aProducts['channels'];
		}

		return false;
	}

	/**
	 * Получение списка каналов, доступных клиенту, выбравшему данный продукт
	 *
	 * @return array
	 */
	public function getSelectedProductChannelsList()
	{
		$aChannels = array();

		$iSelectedProduct = $this->getSubscribeSelectedProduct();
		$aProducts = $this->getProducts();

		if (isset($aProducts[$iSelectedProduct]['channels'])) {
			$aSelectedProductChannels = array_keys($aProducts[$iSelectedProduct]['channels']);
			$aClientChannels = array_values($this->getClientChannels());

			$aChannels = array_intersect($aSelectedProductChannels, $aClientChannels);
		}

		return $aChannels;
	}

	/**
	 * @return array
	 */
	public function getClientProductsChannelListWithAmounts()
	{
		$aProducts = $this->getProductsAndChannels();
		//получаем каналы, доступные клиенту по данной подписке
		$aClientChannels = $this->getClientSubscriptionChannels();

		$aClientChannelsList = array();

		if (isset($aProducts['channels']) && isset($aClientChannels)) {
			foreach ($aClientChannels as $iChannel) {
				//если канал присутствует в списке каналов
				//и находится в списке доступных для данной подписки каналов
				if (isset($aProducts['channels'][$iChannel])
				) {
					$aClientChannelsList[$iChannel] = $this->getSubscriptionLoanAmount() . " рублей " .
						SiteParams::mb_lcfirst(
							ProductsChannelsComponent::formatChannelNameNoOperators($aProducts['channels'][$iChannel])
						);
				}
			}
		}

		return $aClientChannelsList;
	}

	/**
	 * Получение списка продуктов и каналов для данного пользователя.
	 * Проверяет, какие каналы получения денег доступны клиенту, и возвращает только допустимые продукты и каналы
	 * Если нет ничего доступного, выводит соответствующую информацию
	 *
	 * @return array
	 */
	public function getClientProductsAndChannelsList()
	{
		//получаем список продуктов
		$aProducts = $this->getProducts();
		//получаем список каналов
		$aChannels = $this->getProductsChannels();
		//получаем список каналов, доступных клиенту
		$aClientChannels = $this->getClientChannels();
		$aProductsAndChannels = array();
		//проверяем, что получили массивы
		if (is_array($aProducts) && is_array($aChannels) && is_array($aClientChannels)) {

			//перебираем все продукты
			foreach ($aProducts as $aProduct) {
				//получаем из продукта каналы, по которым его можно получить
				$aProductChannels = (isset($aProduct['channels']) && is_array($aProduct['channels']))
					? $aProduct['channels']
					: array();
				//перебираем каналы, по которым можно получить продукт
				foreach ($aProductChannels as $iKey => $aChannel) {
					//проверяем, что у канала есть описание
					//проверяем, что данный канал доступен пользователю
					if (isset($aChannels[$iKey])
						&& in_array($iKey, $aClientChannels)
					) {
						$aProductsAndChannels[($aProduct['id'] . '_' . $iKey)] = $aProduct['name'] . ' ' . SiteParams::mb_lcfirst($aChannels[$iKey]);
					}
				}
			}
		}

		return $aProductsAndChannels;
	}

	/**
	 * Получение названия продукта по ID
	 *
	 * @param $iProductId
	 *
	 * @return bool|string
	 */
	public function getProductNameById($iProductId)
	{
		$aProducts = $this->getProducts();

		return (isset($aProducts[$iProductId]['name']))
			? $aProducts[$iProductId]['name']
			: false;
	}

	/**
	 * Получение стоимости продукта по ID
	 *
	 * @param $iProductId
	 *
	 * @param $iChannelId
	 *
	 * @return bool|string
	 */
	public function getProductCostById($iProductId, $iChannelId = null)
	{
		$aProducts = $this->getProducts();

		$iSubscriptionCost = 0;

		if (isset($aProducts[$iProductId]['subscription_cost'])) {
			$iSubscriptionCost += $aProducts[$iProductId]['subscription_cost'];
		}
		if ($iChannelId && isset($aProducts[$iProductId]['channels'][$iChannelId]['additional_cost'])) {
			$iSubscriptionCost += $aProducts[$iProductId]['channels'][$iChannelId]['additional_cost'];
		}

		return $iSubscriptionCost;
	}

	/**
	 * Получение срока действия продукта по ID
	 *
	 * @param $iProductId
	 *
	 * @return bool|string
	 */
	public function getProductLifetimeById($iProductId)
	{
		$aProducts = $this->getProducts();

		return (isset($aProducts[$iProductId]['subscription_lifetime']))
			? ($aProducts[$iProductId]['subscription_lifetime'] / 3600 / 24)
			: false;
	}

	/**
	 * Получение суммы займа по ID продукта
	 *
	 * @param $iProductId
	 *
	 * @return bool|string
	 */
	public function getProductLoanAmountById($iProductId)
	{
		$aProducts = $this->getProducts();

		return (isset($aProducts[$iProductId]['loan_amount']))
			? $aProducts[$iProductId]['loan_amount']
			: false;
	}

	/**
	 * Получения количества займов для продукта по ID
	 *
	 * @param $iProductId
	 *
	 * @return bool|string
	 */
	public function getProductLoanCountById($iProductId)
	{
		$aProducts = $this->getProducts();

		return (isset($aProducts[$iProductId]['loan_count']))
			? $aProducts[$iProductId]['loan_count']
			: false;
	}

	/**
	 * Получение срока займа по ID продукта
	 *
	 * @param $iProductId
	 *
	 * @return bool|string
	 */
	public function getProductLoanLifetimeById($iProductId)
	{
		$aProducts = $this->getProducts();

		return (isset($aProducts[$iProductId]['loan_lifetime']))
			? ($aProducts[$iProductId]['loan_lifetime'] / 3600 / 24)
			: false;
	}

	/**
	 * Проверка возможности получения займа
	 *
	 * @return bool
	 */
	public function checkLoan()
	{
		if (!isset($this->bIsCanGetLoan)) {
			$this->requestAdminKreddyApi(self::API_ACTION_CHECK_LOAN);

			$this->bIsCanGetLoan = (!$this->getIsNotAllowed()
				&& !$this->getIsNeedSmsAuth()
				&& !$this->getIsError()
			);
		}

		return $this->bIsCanGetLoan;
	}

	/**
	 * Проверка возможности подтвердить займ (индивидуальные условия)
	 *
	 * @return bool
	 */
	public function checkConfirmLoan()
	{
		$this->requestAdminKreddyApi(self::API_ACTION_CHECK_CONFIRM_LOAN);

		return (!$this->getIsNotAllowed()
			&& !$this->getIsNeedSmsAuth()
			&& !$this->getIsError()
		);

	}

	/**
	 * Получение канала, выбранного клиентом по умолчанию
	 *
	 * @return int
	 */
	public function getSelectedChannelId()
	{
		$aClientInfo = $this->getClientInfo();

		return $aClientInfo['subscription']['channel_id'];
	}

	/**
	 * Взять заём, подписанный СМС-кодом
	 *
	 * @param        $iChannelId
	 *
	 * @return bool
	 */
	public function doLoan($iChannelId)
	{

		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_LOAN, array('channel_id' => $iChannelId));

		if ($aResult['code'] === self::ERROR_NONE) {
			$this->setLastSmsMessage($aResult['sms_message']);

			return true;
		} else {
			if (isset($aResult['sms_message'])) {
				$this->setLastSmsMessage($aResult['sms_message']);
			} else {
				$this->setLastSmsMessage(self::ERROR_MESSAGE_UNKNOWN);
			}

			return false;
		}
	}

	/**
	 * Отмена неоплаченной подписки
	 *
	 * @return bool
	 */
	public function doCancelRequest()
	{
		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_CANCEL_REQUEST);

		if ($aResult['code'] === self::ERROR_NONE) {

			return true;
		} else {
			if (isset($aResult['message'])) {
				$this->setLastMessage($aResult['message']);
			} else {
				$this->setLastMessage(self::ERROR_MESSAGE_UNKNOWN);
			}

			return false;
		}
	}

	/**
	 * Отмена запроса на займ (индивидуальных условий)
	 *
	 * @return bool
	 */
	public function doCancelLoanRequest()
	{
		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_CANCEL_LOAN_REQUEST);

		if ($aResult['code'] === self::ERROR_NONE) {

			return true;
		} else {
			if (isset($aResult['message'])) {
				$this->setLastMessage($aResult['message']);
			} else {
				$this->setLastMessage(self::ERROR_MESSAGE_UNKNOWN);
			}

			return false;
		}
	}

	/**
	 * Проверка возможности подписки
	 *
	 * @return bool
	 */
	public function checkSubscribe()
	{
		if (!isset($this->bIsCanSubscribe) || !isset($this->bIsNeedCard)) {
			$this->requestAdminKreddyApi(self::API_ACTION_CHECK_SUBSCRIBE);
			$this->bIsCanSubscribe = !$this->getIsNotAllowed();

			$this->bIsNeedCard = $this->getIsNeedCard();
		}

		return $this->bIsCanSubscribe;
	}

	/**
	 * @return mixed
	 */
	public function checkSubscribeNeedCard()
	{
		if (!isset($this->bIsNeedCard)) {
			$this->checkSubscribe();
		}

		return $this->bIsNeedCard;
	}

	/**
	 * Отправка СМС с кодом подтверждения для действия
	 *
	 * @param       $sAction
	 * @param array $aData
	 * @param bool  $bResend
	 *
	 * @return bool
	 */
	public function doSendSms($sAction, $aData = array(), $bResend = false)
	{
		$aData['sms_resend'] = (int)$bResend;

		//отправляем СМС с кодом
		$aResult = $this->requestAdminKreddyApi($sAction, $aData);

		if ($aResult['code'] === self::ERROR_NEED_SMS_CODE && isset($aResult['sms_status']) && $aResult['sms_status'] === self::SMS_SEND_OK) {
			$this->setLastSmsMessage($aResult['sms_message']);

			return true;
		} else {
			if (isset($aResult['sms_message'])) {
				$this->setLastSmsMessage($aResult['sms_message']);
			} else {
				$this->setLastSmsMessage(self::ERROR_MESSAGE_UNKNOWN);
			}

			return false;
		}
	}

	/**
	 * Проверка, правильный ли код СМС
	 *
	 * @param       $sSmsCode
	 * @param       $sAction
	 * @param array $aData
	 *
	 * @internal param $sType
	 * @return bool
	 */
	public function doCheckSms($sAction, $sSmsCode, $aData = array())
	{
		// если смена пароля - нужен другой экшн, там другой процесс
		if ($sAction == self::API_ACTION_CHANGE_PASSWORD) {
			return $this->changePassword($sSmsCode, $aData);
		}

		$aData['sms_code'] = $sSmsCode;

		$aResult = $this->requestAdminKreddyApi($sAction, $aData);

		return $this->checkChangeResultMessage($aResult);
	}

	/**
	 * Подписка на сервис
	 *
	 * @param        $iProduct
	 *
	 * @return bool
	 */
	public function doSubscribe($iProduct)
	{
		$aRequestData = array(
			'product_id'  => $iProduct,
			'tracking_id' => Yii::app()->siteParams->getTrackingId(),
		);

		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_SUBSCRIBE, $aRequestData);

		if ($aResult['code'] === self::ERROR_NONE) {
			if (isset($aResult['scoring_result'])) {
				$this->setScoringResult($aResult['scoring_result']);
			}
			$this->setLastSmsMessage($aResult['sms_message']);

			return true;
		} else {
			if (isset($aResult['sms_message'])) {
				$this->setScoringResult(null);
				$this->setLastSmsMessage($aResult['sms_message']);
			} else {
				$this->setScoringResult(null);
				$this->setLastSmsMessage(self::ERROR_MESSAGE_UNKNOWN);
			}

			return false;
		}
	}

	/**
	 * @param $sSmsCode
	 * @param $iProduct
	 * @param $iChannelId
	 * @param $iAmount
	 * @param $iTime
	 *
	 * @return bool
	 */
	public function doSubscribeFlexible($sSmsCode, $iProduct, $iChannelId, $iAmount, $iTime)
	{
		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_SUBSCRIBE,
			array('sms_code' => $sSmsCode, 'product_id' => $iProduct, 'channel_id' => $iChannelId, 'custom_options' => array('loan_amount' => $iAmount, 'loan_lifetime' => $iTime)));

		if ($aResult['code'] === self::ERROR_NONE && $aResult['sms_status'] === self::SMS_AUTH_OK) {
			if (isset($aResult['scoring_result'])) {
				$this->setScoringResult($aResult['scoring_result']);
			}
			$this->setLastSmsMessage($aResult['sms_message']);

			return true;
		} else {
			if (isset($aResult['sms_message'])) {
				$this->setScoringResult(null);
				$this->setLastSmsMessage($aResult['sms_message']);
			} else {
				$this->setScoringResult(null);
				$this->setLastSmsMessage(self::ERROR_MESSAGE_UNKNOWN);
			}

			return false;
		}
	}

	/**
	 * Заявка на смену пароля, подписанная СМС-кодом
	 *
	 * @param $sSmsCode
	 * @param $aData
	 *
	 * @return bool
	 */
	public function changePassword($sSmsCode, $aData)
	{
		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_CHANGE_PASSWORD, $aData + array('sms_code' => $sSmsCode));

		$bResult = $this->checkChangeResultMessage($aResult);

		if ($bResult) {
			//обновляем токен сессии в связи со сменой пароля (иначе разлогинит, т.к. пароль в старом токене другой)
			$this->setSessionToken($aResult['token']);
			$this->token = $aResult['token'];
			//ставим флаг успешной СМС-авторизации
			$this->setSmsAuthDone(true);
		}

		return $bResult;
	}

	/**
	 * Привязка банковской карты к аккаунту
	 *
	 * @param AddCardForm $oCardForm
	 *
	 * @return bool
	 */
	public function addClientCard(AddCardForm $oCardForm)
	{


		$aAddCardForm = array(
			'card_pan'          => $oCardForm->sCardPan,
			'card_month'        => $oCardForm->sCardMonth,
			'card_year'         => $oCardForm->sCardYear,

			'card_cvc'          => $oCardForm->sCardCvc,
			'card_printed_name' => $oCardForm->sCardHolderName,
		);

		if (Yii::app()->adminKreddyApi->isCardVerifyNeedAdditionalFields()) {
			$aAdditionalCardFields = array(
				'email'        => $oCardForm->sEmail,
				'address'      => $oCardForm->sAddress,
				'city'         => $oCardForm->sCity,
				'zip_code'     => $oCardForm->sZipCode,
				'country'      => $oCardForm->sCountry,

				'ip'           => Yii::app()->request->getUserHostAddress(),
				'redirect_url' => Yii::app()->createAbsoluteUrl('/account/returnFrom3DSecurity'),
			);

			$aAddCardForm = CMap::mergeArray($aAddCardForm, $aAdditionalCardFields);
		}
		$aRequest = array(
			'AddCard' => $aAddCardForm,
		);

		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_ADD_CARD, $aRequest);

		if ($aResult['code'] === self::ERROR_NONE) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $sCardVerifyAmount
	 *
	 * @return bool
	 */
	public function verifyClientCard($sCardVerifyAmount)
	{
		$aRequest = array(
			'card_verify_amount' => $sCardVerifyAmount,
		);

		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_VERIFY_CARD, $aRequest);

		$this->setLastMessage($aResult['message']);

		return ($aResult['code'] === self::ERROR_NONE);
	}

	/**
	 * Проверяет, требуется ли клиенту пройти верификацию карты
	 * 0 - не может, нужно сначала добавить карту
	 *
	 * @return stdClass
	 */
	public function checkVerifyCardStatus()
	{
		$sCardVerify3DHtml = null;
		$bCardVerifyNeedWait = false;
		$bCardVerify3DsError = false;

		if (isset($this->oCardVerifyStatus)) {
			return $this->oCardVerifyStatus;
		}

		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_CHECK_CAN_VERIFY_CARD);

		//если код "требуется пройти 3ds"
		if ($aResult['code'] == self::ERROR_NEED_3DS_PROCESS) {
			$sCardVerify3DHtml = isset($aResult['html']) ?
				$aResult['html'] :
				null;
		}

		//если код "ждите"
		if ($aResult['code'] == self::ERROR_NEED_WAIT) {
			$bCardVerifyNeedWait = true;
		}

		//если код "ошибка 3ds"
		if ($aResult['code'] == self::ERROR_VERIFY_3DS) {
			$bCardVerify3DsError = true;
		}


		$oResult = new stdClass();
		$oResult->bCardCanVerify = !empty($aResult['card_can_verify']);
		$oResult->sCardVerify3DHtml = $sCardVerify3DHtml;
		$oResult->bCardVerify3DsError = $bCardVerify3DsError;
		$oResult->bCardVerifyNeedWait = $bCardVerifyNeedWait;
		$oResult->bCardVerifyExists = !empty($aResult['verify_exists']);
		$oResult->bCardVerifyNeedAdditionalFields = !empty($aResult['verify_additional_fields']);

		$this->oCardVerifyStatus = $oResult;

		return $oResult;
	}

	/**
	 * @return mixed
	 */
	public function isCardVerifyNeedAdditionalFields()
	{
		if (!isset($this->oCardVerifyStatus)) {
			$this->checkVerifyCardStatus();
		}

		return $this->oCardVerifyStatus->bCardVerifyNeedAdditionalFields;
	}

	/**
	 * @return mixed
	 */
	public function checkCardVerifyExists()
	{
		if (!isset($this->oCardVerifyStatus)) {
			$this->checkVerifyCardStatus();
		}

		return $this->oCardVerifyStatus->bCardVerifyExists;
	}

	/**
	 * Первая ли это идентификация будет у клиента?
	 *
	 * @return bool
	 */
	public function isFirstIdentification()
	{
		$aData = $this->getClientInfo();

		return $aData['first_identification'];
	}

	/**
	 * Проверка, нужна ли видеоидентификация
	 *
	 * @return bool
	 */
	public function checkIsNeedIdentify()
	{
		$this->getData('check_identify');

		return (!$this->getIsError() && $this->getIsNeedIdentify());
	}

	/**
	 * Проверка, нужно ли ввести паспортные данные
	 *
	 * @return bool
	 */
	public function checkIsNeedPassportData()
	{
		$this->getData('check_identify');

		return (!$this->getIsError() && $this->getIsNeedPassportData());
	}

	/**
	 * @return array|bool
	 */
	public function getIdentify()
	{
		$aRequiredFields = array(
			'client_code'    => null,
			'service'        => null,
			'signature'      => null,
			'video_url'      => null,
			'documents'      => null,
			'documents_sign' => null,
			'timestamp'      => null,
		);

		$aResult = $this->getData('identify');

		if (!$this->getIsError()) {
			unset($aResult['code']);
			unset($aResult['message']);
			unset($aResult['sms_message']);
			unset($aResult['sms_code']);
			unset($aResult['sms_status']);

			$aResult = array_intersect_key($aResult, $aRequiredFields);

			return $aResult;
		}

		return false;
	}

	/**
	 * Сохранение выбранного продукта в сессию
	 *
	 * @param $sProduct
	 */
	public function setSubscribeSelectedProduct($sProduct)
	{
		Yii::app()->session['subscribeSelectedProduct'] = $sProduct;
	}

	/**
	 * Получение выбранного продукта из сессии
	 *
	 * @return string|bool
	 */
	public function getSubscribeSelectedProduct()
	{
		return (isset(Yii::app()->session['subscribeSelectedProduct']))
			? Yii::app()->session['subscribeSelectedProduct'] :
			false;
	}

	/**
	 * Сохранение в сессию выбранного канала получения продукта
	 *
	 * @param $iChannel
	 */
	public function setLoanSelectedChannel($iChannel)
	{
		Yii::app()->session['loanSelectedChannel'] = $iChannel;
	}

	/**
	 * Получение выбранного канала из сессии
	 *
	 * @return string|bool
	 */
	public function getLoanSelectedChannel()
	{
		return (isset(Yii::app()->session['loanSelectedChannel']))
			? Yii::app()->session['loanSelectedChannel'] :
			false;
	}

	/**
	 * Сохранение выбранного канала в сессию
	 *
	 * @param $sChannel
	 */
	public function setSubscribeSelectedChannel($sChannel)
	{
		Yii::app()->session['subscribeSelectedChannel'] = $sChannel;
	}

	/**
	 * Получение выбранного продукта из сессии
	 *
	 * @return string|bool
	 */
	public function getSubscribeSelectedChannel()
	{
		return (isset(Yii::app()->session['subscribeSelectedChannel']))
			? Yii::app()->session['subscribeSelectedChannel'] :
			false;
	}

	/**
	 * Роутер запросов для получения данных
	 * Получает запросы на данные и перенаправляет на requestAdminKreddyApi() с нужным экшном
	 *
	 * @param $sType
	 *
	 * @return array
	 */
	private function getData($sType)
	{
		//проверяем, какие данные запрошены, и выбираем необходимый экшн и отправляем запрос в API
		switch ($sType) {
			case 'info':
				$sAction = self::API_ACTION_GET_INFO;
				break;
			case 'full_data':
				$sAction = self::API_ACTION_GET_FULL_CLIENT_DATA;
				break;
			case 'history':
				$sAction = self::API_ACTION_GET_HISTORY;
				break;
			case 'products_and_channels':
				$sAction = self::API_ACTION_GET_PRODUCTS;
				break;
			case 'identify':
				$sAction = self::API_ACTION_GET_IDENTIFY;
				break;
			case 'check_identify':
				$sAction = self::API_ACTION_CHECK_IDENTIFY;
				break;
			default:
				$sAction = self::API_ACTION_GET_INFO;
				break;
		}

		if ($sAction == 'check_identify' && !empty($this->aCheckIdentify)) {
			$aData = $this->aCheckIdentify;
			$this->setLastMessage($aData['message']);
			$this->setLastCode($aData['code']);
		} else {
			$aData = $this->requestAdminKreddyApi($sAction);
			if ($sAction == 'check_identify') {
				$this->aCheckIdentify = $aData;
			}
		}

		return $aData;
	}

	/**
	 * Интерфейс для обращения к API через curl
	 *
	 * @param       $sAction
	 * @param array $aRequest
	 *
	 * @return array
	 */
	private function requestAdminKreddyApi($sAction, $aRequest = array())
	{
		$sApiUrl = (!Yii::app()->params['bApiTestModeIsOn']) ? $this->sApiUrl : $this->sTestApiUrl;
		$aData = array('code' => self::ERROR_AUTH, 'message' => self::ERROR_MESSAGE_UNKNOWN);

		$ch = curl_init($sApiUrl . $sAction);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);

		if (SiteParams::getIsIvanovoSite()) {
			$iEntryPoint = 8;
		} else {
			$iEntryPoint = 1;
		}

		$aRequest = array_merge(array('token' => $this->getSessionToken(), 'entry_point' => $iEntryPoint), $aRequest);

		//если включен debug то делаем чистку данных и trace
		if (defined('YII_DEBUG') && YII_DEBUG) {
			$aTraceData = $aRequest;
			//если есть card_cvc то удаляем его
			if (isset($aTraceData['card_cvc'])) {
				$aTraceData['card_cvc'] = '***';
			}
			if (isset($aTraceData['card_pan'])) {
				$aTraceData['card_pan'] = substr_replace($aTraceData['card_pan'], '********', 4, 8);
			}
			//трейс с чисткой 16-цифровых значений для маскировки номеров карт
			Yii::trace("Action: " . $sAction . " - Request: " . CJSON::encode($aTraceData));
		}

		if (isset($aRequest['files'])) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $aRequest);
		} else {
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aRequest));
		}

		$response = curl_exec($ch);

		if ($response) {
			Yii::trace("Action: " . $sAction . " - Response: " . $response);
			$aGetData = CJSON::decode($response);

			if (is_array($aGetData)) {

				// в случае если сервер ответил, но не передал message,
				$aData = array(
					'message'     => '',
					'sms_message' => '',
					'sms_code'    => '',
					'sms_status'  => '',
				);

				$aData = CMap::mergeArray($aData, $aGetData);
				$this->setLastSmsStatus($aData['sms_status']);
			}
		}
		$this->setLastMessage($aData['message']);
		$this->setLastCode($aData['code']);

		return $aData;
	}

	/**
	 * Получение токена, сохраненного в сессию
	 *
	 * @return mixed
	 */
	private function getSessionToken()
	{
		return Yii::app()->session['akApi_token'];
	}

	/**
	 * Сохранение токена в сессию
	 *
	 * @param $token
	 */
	private function setSessionToken($token)
	{
		Yii::app()->session['akApi_token'] = $token;
	}

	/**
	 * @param $sToken
	 *
	 * @return bool
	 */
	public function loginWithToken($sToken)
	{
		$this->setSessionToken($sToken);
		$bResult = $this->updateClientToken();
		$this->getClientInfo(true);

		return $bResult;
	}

	/**
	 * очищаем сессии, связанные с отправкой SMS (форма SMS пароль)
	 */
	public function clearSmsAuthState()
	{
		Yii::app()->session['smsAuthDone'] = null;
	}

	/**
	 * @param $bSmsAuthDone
	 */
	public function setSmsAuthDone($bSmsAuthDone)
	{
		Yii::app()->session['smsAuthDone'] = $bSmsAuthDone;
	}

	/**
	 * Передаем полученный от API результат и извлекаем из него код
	 *
	 * @param $aResult
	 *
	 * @return int
	 */
	public function getResultStatus($aResult)
	{
		if (isset($aResult) && isset($aResult['code'])) {
			$iRet = $aResult['code'];
		} else {
			$iRet = self::ERROR_AUTH;
		}

		return $iRet;
	}

	/**
	 * Проверяем полученный ответ API на его уровень авторизации
	 * коды 0, 9, 10 - авторизация в порядке
	 *
	 * @return bool
	 */
	public function getIsAuth()
	{
		$aInfo = Yii::app()->adminKreddyApi->getClientInfo();
		$iStatus = $this->getResultStatus($aInfo);

		return ($iStatus === self::ERROR_NONE || $iStatus === self::ERROR_NEED_SMS_AUTH || $iStatus === self::ERROR_NEED_SMS_CODE || $iStatus === self::ERROR_NEED_REDIRECT);
	}

	/**
	 * Проверяем, требует ли ответ API авторизации по СМС
	 *
	 * @return bool
	 */
	public function getIsNeedSmsAuth()
	{
		$aInfo = $this->getClientInfo();

		return ($aInfo['code'] === self::ERROR_NEED_SMS_AUTH);
	}

	/**
	 * Проверяем, требует ли последний запрошенный action API подтверждения одноразовым СМС-кодом
	 *
	 * @return bool
	 */
	public function getIsNeedSmsCode()
	{
		return ($this->getLastCode() === self::ERROR_NEED_SMS_CODE);
	}

	/**
	 * Сохраняем в сессию телефон, на который запрошено восстановление пароля
	 *
	 * @param array $aData
	 *
	 */
	public function setResetPassData(array $aData)
	{
		Yii::app()->session['resetPasswordData'] = $aData;
	}

	/**
	 * Загрузка из сессии сохраненного номера телефона, указанного в форме восстановления пароля
	 *
	 * @return string
	 */
	public function getResetPassData()
	{
		return (!empty(Yii::app()->session['resetPasswordData'])) ? Yii::app()->session['resetPasswordData'] : '';
	}

	/**
	 * Проверяем, есть ли в сессии номер телефна, указанный в форме восстановления пароля
	 *
	 * @return bool
	 */
	public function checkResetPassPhone()
	{
		return (!empty(Yii::app()->session['resetPasswordData']['phone']));
	}

	/**
	 * Проверяем статус СМС-авторизации для переданного результата
	 *
	 * @param $aResult
	 *
	 * @return bool
	 */
	public function checkSmsAuthStatus($aResult)
	{
		if ($aResult['sms_status'] === self::SMS_AUTH_OK) {
			$this->setSmsAuthDone(true);

			return true;
		}

		return false;
	}

	/**
	 * Проверяем, авторизован ли пользователь через СМС-пароль
	 *
	 * @return bool
	 */
	public function getIsSmsAuth()
	{
		return (!empty(Yii::app()->session['smsAuthDone']));
	}

	/**
	 * Сохраняем последнее полученное сообщение о СМС-статусе запроса
	 *
	 * @param $sMessage
	 */
	public function setLastSmsMessage($sMessage)
	{
		$this->sLastSmsMessage = $sMessage;
	}

	/**
	 * Возвращаем последнее полученное сообщение о СМС-статусе запроса
	 *
	 * @return string
	 */
	public function getLastSmsMessage()
	{
		return $this->sLastSmsMessage;
	}

	/**
	 * Сохраняем последнее полученное сообщение о статусе запроса
	 *
	 * @param $sMessage
	 */
	public function setLastMessage($sMessage)
	{
		$this->sLastMessage = $sMessage;
	}

	/**
	 * Возвращаем последнее полученное сообщение о статусе запроса
	 *
	 * @return string
	 */
	public function getLastMessage()
	{
		return $this->sLastMessage;
	}

	/**
	 * @param $iResult
	 */
	public function setScoringResult($iResult)
	{
		$this->iScoringResult = $iResult;
	}

	/**
	 * @return mixed
	 */
	public function getScoringResult()
	{
		return $this->iScoringResult;
	}

	/**
	 * Сохраняем последний полученный код статуса запроса
	 *
	 * @param $iCode
	 *
	 */
	public function setLastCode($iCode)
	{
		$this->iLastCode = $iCode;
	}

	/**
	 * Возвращаем последний полученный код статуса запроса
	 *
	 * @return integer
	 */
	public function getLastCode()
	{
		return $this->iLastCode;
	}

	/**
	 * Проверка, вернул ли последний выполненный запрос сообщение "операция недоступна" - код 11
	 *
	 * @return bool
	 */
	public function getIsNotAllowed()
	{
		return ($this->getLastCode() === self::ERROR_NOT_ALLOWED || $this->getLastCode() === self::ERROR_NEED_REDIRECT);
	}

	/**
	 * Проверка ответа checkSubscribe, требуется ли привязать банковскую карту
	 *
	 * @return bool
	 */
	private function getIsNeedCard()
	{
		return ($this->getLastCode() === self::ERROR_NEED_CARD);
	}

	/**
	 * Проверка, вернул ли последний выполненный запрос ошибку (коды 0, 9 и 10 - не являются кодами ошибок)
	 *
	 * @return bool
	 */
	public function getIsError()
	{
		return ($this->getLastCode() !== self::ERROR_NONE
			&& $this->getLastCode() !== self::ERROR_NEED_SMS_AUTH
			&& $this->getLastCode() !== self::ERROR_NEED_SMS_CODE
			&& $this->getLastCode() !== self::ERROR_NOT_ALLOWED
			&& $this->getLastCode() !== self::ERROR_NEED_IDENTIFY
			&& $this->getLastCode() !== self::ERROR_NEED_PASSPORT_DATA
			&& $this->getLastCode() !== self::ERROR_NEED_REDIRECT
			&& $this->getLastCode() !== self::ERROR_NEED_WAIT
			&& $this->getLastCode() !== self::ERROR_NEED_3DS_PROCESS
		);
	}

	/**
	 * @return bool
	 */
	public function getIsClientExistsError()
	{
		return $this->getLastCode() === self::ERROR_CLIENT_EXISTS;
	}

	/**
	 * Проверка, требуется ли видеоидентификация
	 *
	 * @return bool
	 */
	public function getIsNeedIdentify()
	{
		return ($this->getLastCode() === self::ERROR_NEED_IDENTIFY);
	}

	/**
	 * Проверка, требуется ли подтверждение/изменение паспортных данных
	 *
	 * @return bool
	 */
	public function getIsNeedPassportData()
	{
		return ($this->getLastCode() === self::ERROR_NEED_PASSPORT_DATA);
	}

	/**
	 * @return string
	 */
	public function getDoSubscribeMessage()
	{
		$iScoringResult = $this->getScoringResult();

		if (empty($iScoringResult) || SiteParams::getIsIvanovoSite()) {
			return self::C_DO_SUBSCRIBE_MSG;
		}

		switch ($iScoringResult) {
			case self::C_SCORING_ACCEPT:
				$sMessage = strtr($this->getAutomaticScoringMessage(), $this->formatStatusMessage());

				return $sMessage;
				break;
			case self::C_SCORING_CANCEL:
				return self::C_DO_SUBSCRIBE_MSG_SCORING_CANCELED;
				break;
			default:
				return self::C_DO_SUBSCRIBE_MSG;
		}

	}

	/**
	 * Достаем сообщение для автоматического скоринга в зависимости от типа продукта
	 *
	 * @return string
	 */
	private function getAutomaticScoringMessage()
	{
		$iProductType = $this->getSubscriptionRequestType();

		if ($iProductType == AdminKreddyApiComponent::PRODUCT_TYPE_KREDDY_LINE_POSTPAID) {
			return self::C_DO_SUBSCRIBE_MSG_SCORING_ACCEPTED_POSTPAID;
		}

		return self::C_DO_SUBSCRIBE_MSG_SCORING_ACCEPTED;
	}

	/**
	 * @return string
	 */
	public function getDoLoanMessage()
	{
		$sMessage = strtr(self::C_DO_LOAN_MSG, $this->formatStatusMessage());

		return $sMessage;
	}

	/**
	 * @return string
	 */
	public function getNoAvailableProductsMessage()
	{
		return self::C_NO_AVAILABLE_PRODUCTS;
	}

	/**
	 * @return string
	 */
	public function getSubscriptionNotAvailableMessage()
	{
		if (SiteParams::getIsIvanovoSite()) {
			$sMessage = self::C_SUBSCRIPTION_NOT_AVAILABLE_IVANOVO;
		} else {
			$sMessage = self::C_SUBSCRIPTION_NOT_AVAILABLE;
		}

		$sMessage = strtr($sMessage, $this->formatStatusMessage());

		return $sMessage;
	}

	/**
	 * @return string
	 */
	public function getLoanNotAvailableMessage()
	{
		$sMessage = strtr(self::C_LOAN_NOT_AVAILABLE, $this->formatStatusMessage());

		return $sMessage;
	}

	/**
	 * Получаем данные от API и выдаем соответствующий массив для создания виджета гибкого займа
	 *
	 * @return array
	 */
	public function getFlexibleProduct()
	{
		$aProducts = $this->getProducts();


		$aFlexProduct = array();
		if (is_array($aProducts)) {
			foreach ($aProducts as $aProduct) {
				$iAmount = (!empty($aProduct['amount'])) ? $aProduct['amount'] : 0;
				$aFlexProduct[$iAmount] = $iAmount;
			}
		}

		return $aFlexProduct;
	}

	/**
	 * Получаем список дней (сроков займа) для "гибкого" продукта
	 *
	 * @return array|bool
	 */
	public function getFlexibleProductTime()
	{
		$aProducts = $this->getProducts();

		$aDays = array();
		if (is_array($aProducts)) {
			$aProduct = reset($aProducts);
			if (is_array($aProduct) && isset($aProduct['percentage']) && is_array($aProduct['percentage'])) {
				foreach ($aProduct['percentage'] as $iKey => $aDayPercent) {
					$aDays[$iKey] = $iKey;
				}
			}
		}

		return $aDays;
	}

	/**
	 * Получаем процентную сетку для "гибкого" продукта
	 *
	 * @return array|bool
	 */
	public function getFlexibleProductPercentage()
	{
		$aProducts = $this->getProducts();

		$aFlexProductPercentage = array();
		if (is_array($aProducts)) {
			foreach ($aProducts as $aProduct) {
				$iAmount = (!empty($aProduct['amount'])) ? $aProduct['amount'] : 0;
				$aFlexProductPercentage[$iAmount] = isset($aProduct['percentage']) ? $aProduct['percentage'] : array();
			}
		}

		return $aFlexProductPercentage;
	}

	/**
	 * Получаем стоимости каналов для "гибких" продуктов
	 *
	 * @return array
	 */
	public function getFlexibleProductChannelCosts()
	{
		$aProducts = $this->getProducts();


		$aFlexChannelCosts = array();
		if (is_array($aProducts)) {
			foreach ($aProducts as $aProduct) {
				if (isset($aProduct['amount']) && isset($aProduct['channels']) && is_array($aProduct['channels'])) {
					foreach ($aProduct['channels'] as $iKey => $aChannel) {
						if (isset($aChannel['additional_cost']) && ($aChannel['additional_cost'] > 0)) {
							if (!empty($aFlexChannelCosts[$aProduct['amount']])) {
								$aFlexChannelCosts[$aProduct['amount']] += array($iKey => $aChannel['additional_cost']);
							} else {
								$aFlexChannelCosts[$aProduct['amount']] = array($iKey => $aChannel['additional_cost']);
							}
						}
					}
				}


			}
		}

		return $aFlexChannelCosts;
	}

	/**
	 * @param       $oChangeForm
	 * @param array $aData
	 */
	public function setClientChangeData($oChangeForm, array $aData)
	{
		$sSessionName = get_class($oChangeForm);
		Yii::app()->session[$sSessionName] = $aData;
	}

	/**
	 * @param $oChangeForm
	 *
	 * @return mixed
	 */
	public function getClientChangeData($oChangeForm)
	{
		$sSessionName = get_class($oChangeForm);

		return Yii::app()->session[$sSessionName];
	}

	/**
	 * @param $sField
	 *
	 * @return string|bool
	 */
	public function getPassportDataField($sField)
	{
		$oChangePassportForm = new ChangePassportForm();

		$aData = $this->getClientChangeData($oChangePassportForm);
		if ($sField === 'passport_change_reason' && !$aData[$sField]) {
			return (!empty(Dictionaries::$aChangePassportReasons[$aData[$sField]]))
				? Dictionaries::$aChangePassportReasons[$aData[$sField]]
				: false;
		}

		return (!empty($aData[$sField]))
			? $aData[$sField]
			: false;
	}

	/**
	 * @param $bClientIsOnIdentify
	 *
	 */
	public function setClientOnIdentify($bClientIsOnIdentify)
	{
		Yii::app()->session['bClientOnIdentify'] = $bClientIsOnIdentify;
	}

	/**
	 * @return bool
	 */
	public function getClientOnIdentify()
	{
		return (!empty(Yii::app()->session['bClientOnIdentify']));
	}

	/**
	 * @return bool|string
	 */
	public function getResetPassPhone()
	{
		$aData = $this->getResetPassData();

		return (!empty($aData['phone'])) ? $aData['phone'] : false;
	}

	/**
	 * @param array $aPassword
	 */
	public function setPassword(array $aPassword)
	{
		Yii::app()->session['aPassword'] = $aPassword;
	}

	/**
	 * @return array
	 */
	public function getPassword()
	{
		return (!empty(Yii::app()->session['aPassword'])) ? Yii::app()->session['aPassword'] : array();
	}

	/**
	 * Отправка СМС сообщения через API (для регистрации)
	 *
	 * @param $sPhone
	 * @param $sMessage
	 *
	 * @return bool
	 */
	public function sendSms($sPhone, $sMessage)
	{
		if (!Yii::app()->params['bSmsGateIsOff']) {

			$this->requestAdminKreddyApi(self::API_ACTION_SEND_SMS, array(
				'number'  => $sPhone,
				'message' => $sMessage,
			));
			if ($this->getIsError()) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Отправка Email сообщения через API (для регистрации)
	 *
	 * @param string $sEmail
	 * @param string $sEmailCode
	 * @param null   $sEmailBackUrl
	 *
	 * @return bool
	 */
	public function sendEmailCode($sEmail, $sEmailCode, $sEmailBackUrl = null)
	{
		if (!Yii::app()->params['bEmailGateIsOff']) {

			$this->requestAdminKreddyApi(self::API_ACTION_SEND_EMAIL_CODE, array(
				'email'          => $sEmail,
				'email_code'     => $sEmailCode,
				'email_back_url' => $sEmailBackUrl,
			));
			if ($this->getIsError()) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function getIsNeedRedirect()
	{
		$aInfo = $this->getClientInfo();

		return ($aInfo['code'] == self::ERROR_NEED_REDIRECT);
	}

	/**
	 * @param $iAmount
	 */
	public function setSubscribeFlexAmount($iAmount)
	{
		Yii::app()->session['subscribeFlexAmount'] = $iAmount;
	}

	/**
	 *
	 */
	public function getSubscribeFlexAmount()
	{
		return (isset(Yii::app()->session['subscribeFlexAmount']))
			? Yii::app()->session['subscribeFlexAmount']
			: false;
	}

	/**
	 * @param $iChannelId
	 */
	public function setSubscribeFlexChannelId($iChannelId)
	{
		Yii::app()->session['subscribeFlexChannelId'] = $iChannelId;
	}

	/**
	 * @return string|bool
	 */
	public function getSubscribeFlexChannelId()
	{
		return (isset(Yii::app()->session['subscribeFlexChannelId']))
			? Yii::app()->session['subscribeFlexChannelId']
			: false;
	}

	/**
	 * Функция получает список каналов в виде строки "1_2_3", и выбирает из списка каналов один, доступный клиенту
	 *
	 * @param $sChannelsId
	 *
	 * @return int
	 */
	public function getClientSelectedChannelByIdString($sChannelsId)
	{
		//список каналов из сессии (выбранный при регистрации канал/список каналов) разбиваем на массив каналов (если пришел в виде "1_2_3")
		$aChannelsId = explode('_', $sChannelsId);

		//получаем список каналов, доступных клиен
		$aClientChannels = Yii::app()->adminKreddyApi->getClientChannels();

		$iChannelId = 0;
		//если есть канал из сессии и список каналов клиента не пуст
		if (!empty($aClientChannels) && !empty($aChannelsId) > 0) {
			//перебираем список каналов клиента
			foreach ($aClientChannels as $iClientChannel) {
				//если текущий канал есть в массиве каналов из сессии, то его номер устанавливаем в $iChannelId
				if (in_array($iClientChannel, $aChannelsId)) {
					$iChannelId = (int)$iClientChannel;

				}
			}
		}

		return $iChannelId;
	}

	/**
	 * @param $iTime
	 */
	public function setSubscribeFlexTime($iTime)
	{
		Yii::app()->session['subscribeFlexTime'] = $iTime;
	}

	/**
	 * @param bool $bFormat
	 *
	 * @return bool
	 */
	public function getSubscribeFlexTime($bFormat = false)
	{

		$iFlexTime = (isset(Yii::app()->session['subscribeFlexTime']))
			? Yii::app()->session['subscribeFlexTime']
			: false;
		if ($bFormat) {

			$iFlexTimeTo = time() + ($iFlexTime * 60 * 60 * 24);
			SiteParams::formatRusDate($iFlexTimeTo, false);


			return ($iFlexTime) ? SiteParams::formatRusDate($iFlexTimeTo, false) : false;
		}

		return $iFlexTime;
	}

	/**
	 * Считаем стоимость с учетом процентов и стоимости использования канала
	 */
	public function getSubscribeFlexCost()
	{
		$iAmount = $this->getSubscribeFlexAmount();
		$iTime = $this->getSubscribeFlexTime();
		$iChannelId = $this->getSubscribeFlexChannelId();
		$aPercentage = $this->getFlexibleProductPercentage();

		$aChannelCosts = $this->getFlexibleProductChannelCosts();

		// получаем стоимость выбранного канала
		$iChannelCost = (!empty($aChannelCosts[$iAmount][$iChannelId]))
			? $aChannelCosts[$iAmount][$iChannelId]
			: 0;
		$iPercent = (!empty($aPercentage[$iAmount][$iTime]))
			? $aPercentage[$iAmount][$iTime] :
			0;

		return $iAmount + $iChannelCost + $iPercent;
	}

	/**
	 * Получаем ID продукта по его amount'у
	 *
	 * @return int
	 */
	public function getSubscribeFlexProductId()
	{
		$aProducts = $this->getProducts();
		$iAmount = (int)$this->getSubscribeFlexAmount();

		$iProductId = 0;
		if (is_array($aProducts)) {
			foreach ($aProducts as $aProduct) {
				if (!empty($aProduct['amount']) && (int)$aProduct['amount'] === $iAmount) {
					$iProductId = $aProduct['id'];
				}
			}
		}

		return $iProductId;
	}

	/**
	 * Проверка в getInfo есть ли привязанная карта
	 *
	 * @return bool
	 */
	public function getIsClientCardExists()
	{
		$aClientInfo = $this->getClientInfo();

		return (isset($aClientInfo['bank_card_exists']) && $aClientInfo['bank_card_exists'] === true);
	}

	/**
	 * @return bool
	 */
	public function getIsFirstAddingCard()
	{
		$bIsFirstAddingCard = (empty(Yii::app()->session['account_addCard']));

		if ($bIsFirstAddingCard) {
			Yii::app()->session['account_addCard'] = true;
		}

		return $bIsFirstAddingCard;
	}

	/**
	 * @return bool
	 */
	public function getIsFirstVerifyingCard()
	{
		$bIsFirstVerifyingCard = (empty(Yii::app()->session['account_verifyCard']));

		if ($bIsFirstVerifyingCard) {
			Yii::app()->session['account_verifyCard'] = true;
		}

		return $bIsFirstVerifyingCard;
	}

	/**
	 * Установка флага, что сессия пользователя истекла или не истекла.
	 *
	 * @param bool $bFlag
	 */
	public function setUserSessionExpired($bFlag = true)
	{
		Yii::app()->request->cookies['accountSessionExpired'] = new CHttpCookie('accountSessionExpired', $bFlag);
	}

	/**
	 * Истекла ли сессия пользователя
	 *
	 * @return bool
	 */
	public function getIsUserSessionExpired()
	{
		$bResult = (!empty(Yii::app()->request->cookies['accountSessionExpired']->value));

		// если непусто, очищаем куку, чтобы сообщение показывалось всего один раз.
		if ($bResult) {
			unset(Yii::app()->request->cookies['accountSessionExpired']);
		}

		return $bResult;
	}

	/**
	 * @param $aResult
	 *
	 * @return bool
	 */
	private function checkChangeResultMessage($aResult)
	{
		// Ошибок нет
		if ($aResult['code'] === self::ERROR_NONE && $aResult['sms_status'] === self::SMS_AUTH_OK) {

			$this->setLastSmsMessage($aResult['sms_message']);

			return true;
		}

		// в случае если потеряна сессия с API, то sms_status не придет, надо проверить
		if (!isset($aResult['sms_status'])) {
			$this->setLastSmsMessage(self::ERROR_MESSAGE_UNKNOWN);

			return false;
		}

		// смс не ок - отображаем ошибку смс
		if ($aResult['sms_status'] !== self::SMS_AUTH_OK && $aResult['sms_message']) {

			$this->setLastSmsMessage($aResult['sms_message']);

		} elseif ($aResult['sms_status'] === self::SMS_AUTH_OK) {

			$this->setLastSmsMessage($aResult['message']);

		} else {

			$this->setLastSmsMessage(self::ERROR_MESSAGE_UNKNOWN);

		}

		return false;
	}

	/**
	 * @param $iSmsCode
	 */
	private function setLastSmsStatus($iSmsCode)
	{
		$this->iSmsCode = $iSmsCode;
	}

	/**
	 * @return bool
	 */
	public function isSuccessfulLastSmsCode()
	{
		return $this->iSmsCode == self::SMS_AUTH_OK;
	}

	/**
	 * @param $aRequest
	 *
	 * @return array
	 */
	public function sendInfoFromEmail($aRequest)
	{
		return $this->requestAdminKreddyApi(self::API_ACTION_EMAIL_INFO, $aRequest);
	}

	/**
	 * Стоимость оформляемого продукта для процедуры оформления subscribe
	 *
	 * @return bool|string
	 */
	private function getSubscribeProductCost()
	{
		$iProductId = Yii::app()->adminKreddyApi->getSubscribeSelectedProduct();
		$iChannelId = Yii::app()->adminKreddyApi->getSubscribeSelectedChannel();

		return Yii::app()->adminKreddyApi->getProductCostById($iProductId, $iChannelId);
	}

	/**
	 * @return bool
	 */
	public function isSelectedChannelBankCard()
	{
		$iChannelId = $this->getLoanSelectedChannel();

		$aAvailableChannels = $this->getAvailableChannelValues();

		if (!isset($aAvailableChannels[self::C_CARD])) {
			return false;
		}

		return $aAvailableChannels[self::C_CARD] == $iChannelId;
	}

	/**
	 * Условия погашения абонентской платы в зависимости от типа продукта
	 *
	 * @param $iProductId
	 *
	 * @return string
	 */
	public function getPaymentRuleByProduct($iProductId)
	{
		$aProducts = $this->getProducts();

		if (!isset($aProducts[$iProductId]['type'])) {
			return '';
		}

		$iProductType = $aProducts[$iProductId]['type'];

		if (in_array($iProductType, self::$aPostPaidProducts)) {
			return self::C_KREDDY_LINE_POSTPAID_PAY_RULES;
		}

		return self::C_KREDDY_LINE_PAY_RULES;
	}

	/**
	 * @return bool
	 */
	public function isSubscriptionActive()
	{
		$cClientStatus = $this->getClientStatus();

		return in_array($cClientStatus, $this->aSubscriptionActiveStates);
	}

	/**
	 * Получить информацию по индивидуальным условиям
	 *
	 * @param $hash
	 *
	 * @return array
	 */
	public function getIndividualConditionInfo($hash)
	{
		$aRequest = ['hash' => $hash];

		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_GET_INDIVIDUAL_CONDITION_INFO, $aRequest);

		if (!empty($aResult['condition'])) {
			return $aResult['condition'];
		}

		return array();
	}

	/**
	 * Получить список индивидуальных условий
	 *
	 * @return array
	 */
	public function getIndividualConditionList()
	{
		$aResult = $this->requestAdminKreddyApi(self::API_ACTION_GET_INDIVIDUAL_CONDITION_LIST);

		if (!empty($aResult['conditions'])) {
			return $aResult['conditions'];
		}

		return array();
	}
}
