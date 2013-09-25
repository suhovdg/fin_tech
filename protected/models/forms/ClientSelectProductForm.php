<?php
/**
 * Class ClientSelectProductForm
 *
 * @method FormFieldValidateBehavior asa()
 */
class ClientSelectProductForm extends ClientCreateFormAbstract
{
	public $product;

	/**
	 * @return array
	 */
	public function rules()
	{

		// всегда обязательные поля
		$aRequired =array(
				'product',
			);


		$aRules = $this->getRulesByFields(

			array(
				'product',
			),
			$aRequired
		);
		$aRules[]=array('product', 'in', 'range' => array_keys(Dictionaries::$aProducts),'message' => 'Выберите сумму займа');


		return $aRules;

	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array_merge(
			parent::attributeLabels(),
			array('product' => 'Сумма займа',)
		);
	}

	/**
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'product'
		);
	}
}
