<?php
/**
 * Class ClientFullForm
 *
 * @method FormFieldValidateBehavior asa()
 *
 */

class ClientFullForm2 extends ClientCreateFormAbstract
{

	public $complete;
	public $product;
	public $password;
	public $password_repeat;

	public function rules()
	{
		// всегда обязательные поля
		$aRequired = array(
			'first_name',
			'last_name',
			'third_name',

			'birthday',

			'phone',
			'email',

			'sex',

			'passport_series',
			'passport_number',
			'passport_date',
			'passport_issued',
			'passport_code',

			'document',
			'document_number',

			'address_reg_region',
			'address_reg_city',
			'address_reg_address',

			'address_res_region',
			'address_res_city',
			'address_res_address',

			'relatives_one_fio',
			'relatives_one_phone',

			'job_company',
			'job_position',
			'job_phone',
			'job_time',
			'job_monthly_income',
			'job_monthly_outcome',
			'have_past_credit',

			'numeric_code',
			'complete',
			'secret_question',
			'secret_answer',

			'product'
		);

		$aMyRules =
			array(
				array(
					'phone', 'unique', 'className' => 'ClientData', 'attributeName' => 'phone', 'message' => 'Ошибка! Обратитесь на горячую линию.', 'criteria' => array(
					'condition' => 'complete = :complete AND flag_sms_confirmed = :flag_sms_confirmed', 'params' => array(':complete' => 1, ':flag_sms_confirmed' => 1)
				)
				),
				//TODO сделать сравнение с рабочим телефоном!
				array('relatives_one_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'phone', 'message' => 'Номер не должен совпадать с вашим номером телефона!'),
				array('friends_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'phone', 'message' => 'Номер не должен совпадать с вашим номером телефона!'),

				array('relatives_one_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'job_phone', 'message' => 'Номер не должен совпадать с рабочим номером телефона!'),
				array('friends_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'job_phone', 'message' => 'Номер не должен совпадать с рабочим номером телефона!'),

				array('friends_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'relatives_one_phone', 'allowEmpty' => true, 'message' => 'Номер не должен совпадать с телефоном контактного лица!'),
				array('relatives_one_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'friends_phone', 'allowEmpty' => true, 'message' => 'Номер не должен совпадать с телефоном дополнительного контакта!'),

				array('job_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'relatives_one_phone', 'message' => 'Номер не должен совпадать с телефоном контактного лица!'),
				array('job_phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'friends_phone', 'message' => 'Номер не должен совпадать с телефоном дополнительного контакта!'),

				array('phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'relatives_one_phone', 'message' => 'Номер не должен совпадать с телефоном контактного лица!'),
				array('phone', 'compare', 'operator' => '!=', 'compareAttribute' => 'friends_phone', 'message' => 'Номер не должен совпадать с телефоном дополнительного контакта!'),

				array('complete', 'required', 'requiredValue' => 1, 'message' => 'Необходимо подтвердить свое согласие на обработку данных'),
				array('product', 'in', 'range' => array_keys(Dictionaries::$aProducts2), 'message' => 'Выберите сумму займа'),

				array('friends_phone', 'checkFriendsOnJobPhone', 'phone' => 'phone', 'job_phone' => 'job_phone', 'message' => 'Если номер рабочего телефона совпадает с мобильным, то обязательно требуется дополнительный контакт!'),
				array('friends_fio', 'checkFriendsOnJobPhone', 'phone' => 'phone', 'job_phone' => 'job_phone', 'message' => 'Если номер рабочего телефона совпадает с мобильным, то обязательно требуется дополнительный контакт!'),

				array('password, password_repeat', 'required'),
				//TODO сделать проверку пароля через match
				//array('password','match','pattern'=>'/^[a-zA-Z~!@#$%^&*,.-_+=\s]+$/u'),
				array('password', 'length', 'min' => '8'),
				array('password_repeat', 'compare', 'operator' => '==', 'compareAttribute' => 'password', 'message' => 'Подтверждение пароля не соответствует паролю!'),
			);
		$aRules = array_merge($aMyRules, $this->getRulesByFields(
			array(
				'first_name',
				'last_name',
				'third_name',

				'birthday',

				'phone',
				'email',

				'sex',

				'passport_series',
				'passport_number',
				'passport_date',
				'passport_issued',
				'passport_code',

				'document',
				'document_number',

				'address_reg_region',
				'address_reg_city',
				'address_reg_address',

				'address_reg_as_res',

				'address_res_region',
				'address_res_city',
				'address_res_address',

				'relatives_one_fio',
				'relatives_one_phone',

				'friends_fio',
				'friends_phone',

				'job_company',
				'job_position',
				'job_phone',
				'job_time',
				'job_monthly_income',
				'job_monthly_outcome',
				'have_past_credit',

				'numeric_code',
				'secret_question',
				'secret_answer',
			),
			$aRequired
		));

		return $aRules;

	}

	/**
	 * @return bool|void
	 *
	 * Перед валидацией приводим телефон к 10-значному виду, для валидации уникальности по БД
	 */

	public function beforeValidate()
	{
		if ($this->address_reg_as_res) {
			$this->address_res_region = $this->address_reg_region;
			$this->address_res_city = $this->address_reg_city;
			$this->address_res_address = $this->address_reg_address;
		}

		if ($this->phone) {
			//очистка данных
			$this->phone = ltrim($this->phone, '+ ');
			$this->phone = preg_replace('/[^\d]/', '', $this->phone);

			// убираем лишний знак слева (8-ка или 7-ка)
			if (strlen($this->phone) == 11) {
				$this->phone = substr($this->phone, 1, 10);
			}
		}

		if ($this->job_phone) {
			//очистка данных
			$this->job_phone = ltrim($this->job_phone, '+ ');
			$this->job_phone = preg_replace('/[^\d]/', '', $this->job_phone);

			// убираем лишний знак слева (8-ка или 7-ка)
			if (strlen($this->job_phone) == 11) {
				$this->job_phone = substr($this->job_phone, 1, 10);
			}
		}

		if ($this->document_number) {
			$this->document_number = mb_strtoupper($this->document_number, 'UTF-8');
		}

		if ($this->relatives_one_phone) {
			//очистка данных
			$this->relatives_one_phone = ltrim($this->relatives_one_phone, '+ ');
			$this->relatives_one_phone = preg_replace('/[^\d]/', '', $this->relatives_one_phone);

			// убираем лишний знак слева (8-ка или 7-ка)
			if (strlen($this->relatives_one_phone) == 11) {
				$this->relatives_one_phone = substr($this->relatives_one_phone, 1, 10);
			}
		}

		if ($this->friends_phone) {
			//очистка данных
			$this->friends_phone = ltrim($this->friends_phone, '+ ');
			$this->friends_phone = preg_replace('/[^\d]/', '', $this->friends_phone);

			// убираем лишний знак слева (8-ка или 7-ка)
			if (strlen($this->friends_phone) == 11) {
				$this->friends_phone = substr($this->friends_phone, 1, 10);
			}
		}

		return parent::beforeValidate();
	}

	public function attributeLabels()
	{
		return array_merge(
			parent::attributeLabels(),
			array(
				'relatives_one_fio'   => 'Контактное лицо',
				'relatives_one_phone' => 'Телефон',

				'friends_fio'         => 'Дополнительный контакт (повышает вероятность одобрения)',
				'friends_phone'       => 'Телефон',

				'complete'            => 'Я подтверждаю достоверность введенных данных и даю согласие на их обработку (<a data-toggle="modal" href="#privacy">подробная информация</a>)',

				'secret_question'     => 'Секретный вопрос',
				'secret_answer'       => 'Ответ на секретный вопрос',

				'product'             => 'Сумма займа',
				'address_reg_as_res'  => 'фактический адрес совпадает с пропиской',

				'job_monthly_income'  => 'Среднемесячный доход',
				'job_monthly_outcome' => 'Среднемесячный расход',

				'have_past_credit'    => 'Наличие кредитов и займов в прошлом',

				'password'            => 'Пароль для входа в личный кабинет',
				'password_repeat'     => 'Подтверждение пароля',

			)
		);
	}

	public function checkFriendsOnJobPhone($attribute, $param)
	{
		$this->asa('FormFieldValidateBehavior')->checkFriendsOnJobPhone($attribute, $param);
	}
}

?>