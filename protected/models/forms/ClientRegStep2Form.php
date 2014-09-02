<?php

/**
 * Class ClientRegStep2Form
 */
class ClientRegStep2Form extends ClientFullForm
{
	public $fast_reg;

	private $_validators;

	/**
	 * @return array
	 */
	public function rules()
	{
		$aRules[] = array('birthday', 'required', 'message' => 'Какая дата твоего рождения?');
		$aRules[] = array('email', 'required', 'message' => 'Какой у тебя Email?');
		$aRules[] = array('agree', 'required', 'requiredValue' => 1, 'message' => 'Согласен на обработку твоих данных?');
		$aRules[] = array('phone', 'required', 'message' => 'Какой твой действующий номер телефона?');

		$aRulesFields = array(
			'email',
			'phone',
			'birthday'
		);

		$aRules = CMap::mergeArray(
			$this->getRulesByFields($aRulesFields),
			$aRules);


		$aRules[] = array('fast_reg', 'safe');


		return $aRules;
	}

	/**
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'email',
			'agree',
			'phone',
			'birthday',
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return parent::attributeLabels();
	}


	/**
	 * @return bool|void
	 */
	public function beforeValidate()
	{
		$this->_validators = null;

		return parent::beforeValidate();
	}

	/**
	 * Эта функция требуется обязательно перегруженная для того, чтобы в beforeValidate можно было сбрасывать правила
	 * Сделано для того, чтобы в rules() можно было динамически менять правила валидации в зависимости от значений
	 * тех или иных параметров, и перед валидацией пересоздавать правила на основе изменившихся rules()
	 * В обычном случае валидаторы создаются сразу при инициализации модели, когда данные еще не загружены,
	 * потому требуется их пересоздание перед валидацией в данном случае
	 *
	 * @return CList
	 */
	public function getValidatorList()
	{
		if ($this->_validators === null) {
			$this->_validators = $this->createValidators();
		}

		return $this->_validators;
	}

	/**
	 * Эта функция требуется обязательно перегруженная для того, чтобы в beforeValidate можно было сбрасывать правила
	 *
	 * @param null $attribute
	 *
	 * @return array
	 */
	public function getValidators($attribute = null)
	{
		if ($this->_validators === null) {
			$this->_validators = $this->createValidators();
		}

		$validators = array();
		$scenario = $this->getScenario();
		foreach ($this->_validators as $validator) {
			/**
			 * @var CValidator $validator
			 */
			if ($validator->applyTo($scenario)) {
				if ($attribute === null || in_array($attribute, $validator->attributes, true)) {
					$validators[] = $validator;
				}
			}
		}

		return $validators;
	}

}
