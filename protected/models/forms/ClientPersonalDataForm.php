<?php
/**
 * Форма персональных данных
 *
 * = Поля формы =
 * Контактные данные:
 * + Телефон
 * + Электронная почта
 * Личные данные:
 * + Фамилия
 * + Имя
 * + Отчество
 * + Дата рождения
 * + Пол
 * Паспортные данные:
 * + Серия / номер
 * + Когда выдан
 * + Кем выдан
 * + Код подразделения
 * Второй документ:
 * + Название
 * + Номер
 *
 * Class ClientPersonalDataForm
 *
 * @method FormFieldValidateBehavior asa()
 */
class ClientPersonalDataForm extends ClientCreateFormAbstract
{
	/**
	 * @return array
	 */
	public function rules()
	{

		// всегда обязательные поля
		$aRequired = array(
			'phone',
			'email',

			'first_name',
			'last_name',
			'third_name',

			'birthday',
			'sex',

			'passport_series',
			'passport_number',
			'passport_date',
			'passport_issued',
			'passport_code',

			'document',
			'document_number',
		);

		$aRules =
			array(
				array(
					'phone', 'unique', 'className' => 'ClientData', 'attributeName' => 'phone', 'message' => 'Ошибка! Обратитесь в горячую линию.', 'criteria' => array(
					'condition' => 'complete = :complete AND flag_sms_confirmed = :flag_sms_confirmed', 'params' => array(':complete' => 1, ':flag_sms_confirmed' => 1)
				)
				),
			);
		$aRules = array_merge($aRules, $this->getRulesByFields(
			array(

				'phone',
				'email',

				'first_name',
				'last_name',
				'third_name',

				'birthday',
				'sex',

				'passport_series',
				'passport_number',
				'passport_date',
				'passport_issued',
				'passport_code',

				'document',
				'document_number',

			),
			$aRequired
		));

		return $aRules;

	}

	/**
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'phone',
				'email',

				'first_name',
				'last_name',
				'third_name',

				'birthday',
				'sex',

				'passport_series',
				'passport_number',
				'passport_date',
				'passport_issued',
				'passport_code',

				'document',
				'document_number',
				'condition'
		);
	}

	/**
	 * @return bool|void
	 *
	 * Перед валидацией приводим телефон к 10-значному виду, для валидации уникальности по БД
	 */

	protected function beforeValidate()
	{
		if ($this->phone) {
			//очистка данных
			$this->phone = ltrim($this->phone, '+ ');
			$this->phone = preg_replace('/[^\d]/', '', $this->phone);

			// убираем лишний знак слева (8-ка или 7-ка)
			if (strlen($this->phone) == 11) {
				$this->phone = substr($this->phone, 1, 10);
			}
		}
		if ($this->document_number) {
			$this->document_number = mb_strtoupper($this->document_number, 'UTF-8');
		}

		return parent::beforeValidate();
	}
}
