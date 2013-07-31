<?php
/*
 * Компонент ClientForm
 * занимается обработкой данных сессии и cookies
 * и передачей результата по запросу контроллера форм.
 * Также выполняет команды контроллера по обработке форм.
 *
 * Соответствие шага в сессии обрабатываемой форме и отображаемому представлению
 * Шаг - Модель (отображение)     - Представление
 * 0 - ClientSelectProductForm  - clientselectproduct
 * 1 - ClientGetWayForm         - clientgetway
 * 2 - ClientPersonalDataForm   - clientpersonaldata
 * 3 - ClientAddressForm        - clientaddress
 * 4 - ClientJobInfoForm        - clientjobinfo
 * 5 - ClientSendForm           - clientsend
 * 6 - ______________           - /pages/view/formsent
 */
class ClientForm
{
	private $client_id;
	private $current_step;
	private $done_steps;

	/**
	 * Возвращает модель текущей формы.
	 *
	 * @return ClientCreateFormAbstract
	 */
	public function init()
	{
		if(!$this->client_id = Yii::app()->session['client_id'])
		{
			$this->client_id=false;
		}

		if(!$this->current_step = Yii::app()->session['current_step'])
		{
			Yii::app()->session['current_step']=0;
			$this->current_step=0;
		}

		if(!$this->done_steps = Yii::app()->session['done_steps'])
		{
			Yii::app()->session['done_steps']=0;
			$this->done_steps=0;
		}
	}

	/**
	 * Проверяет, отправлены ли данные с помощью ajax.
	 * Если да, выполняет валидацию модели.
	 *
	 * @return bool
	 */
	public function ajaxValidation()
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===get_class($this->getFormModel()))
		{
			return true;
		}
		return false;
	}

	public function saveAjaxData($clientData, $oForm)
	{
		/*
		 * Функция занимается сохранением данных,
		 * полученных при ajax-валидации,
		 * в сессию, куки и БД
		 */

		/**
		 * @var ClientData $client
		 * @var ClientData $clientData
		 * @var ClientCreateFormAbstract $oForm
		 */
		if(get_class($oForm)==='ClientPersonalDataForm')
		{
			if($oForm->phone)
			{
				/* проверяем, есть ли в куках информация о клиенте
				 * и сравниваем введенный телефон с телефоном в куках.
				 * в случае успешности восстанавливаем client_id из куки.
				 * иначе создаем нового клиента и сохраняем информацию
				 * о нем в сессию и куку.
				 */

				if(($cookieData = $this->getDataFromCookie('client'))&&($this->compareDataInCookie('client','phone',$oForm->phone)))
				{
					Yii::app()->session['client_id'] = $cookieData['client_id'];
					$this->client_id = Yii::app()->session['client_id'];
				}
				else
				{
					/**
					 * функция addClient()ищет клиента в базе по телефону,
					 * и если находит - возвращает запись с указанным телефоном как результат
					 */
					$client=$clientData->addClient($oForm);
					Yii::app()->session['client_id'] = $client->client_id;
					$this->client_id=$client->client_id;

					$data = array('client_id'=>$client->client_id,'phone'=>$client->phone);
					$this->saveDataToCookie('client',$data);
				}
			}
			if($this->client_id)
			{
				$formData=$oForm->getAttributes();
				$formData['product']=Yii::app()->session['product'];
				$formData['get_way']=Yii::app()->session['get_way'];
				$clientData->saveClientDataById($formData,$this->client_id);

				$formData['client_id']=$this->client_id;
				$this->saveDataToCookie(get_class($oForm),$formData);
			}
		}
		else
		{
			if($this->client_id)
			{
				$formData=$oForm->getAttributes();
				$clientData->saveClientDataById($formData,$this->client_id);

				$formData['client_id']=$this->client_id;
				$this->saveDataToCookie(get_class($oForm),$formData);
			}
		}

		return;
	}

	/**
	 * Возвращает модель текущей формы.
	 *
	 * @return int
	 */
	public function getCurrentStep()
	{
		//return $this->current_step;
		return $this->done_steps;
	}

	public function getFormModel() //возвращает модель, соответствующую текущему шагу заполнения формы
	{
		switch($this->current_step)
		{
			case 0:
				return new ClientSelectProductForm();
				break;
			case 1:
				return new ClientSelectGetWayForm();
				break;
			case 2:
				return new ClientPersonalDataForm();
				break;
			case 3:
				return new ClientAddressForm();
				break;
			case 4:
				return new ClientJobInfoForm();
				break;
			case 5:
				return new ClientSendForm();
				break;
			default:
				return new ClientSelectProductForm();
				break;
		}
	}

	/**
	 * Возвращает название необходимого для генерации представления.
	 *
	 * @return string
	 */
	public function getView()
	{
		switch($this->current_step)
		{
			case 0:
				return 'clientselectproduct';
				break;
			case 1:
				return 'clientselectgetway';
				break;
			case 2:
				return 'clientpersonaldata';
				break;
			case 3:
				return 'clientaddress';
				break;
			case 4:
				return 'clientjobinfo';
				break;
			case 5:
				return 'clientsend';
				break;
			default:
				return 'clientselectproduct';
				break;
		}
	}

	/**
	 * Возвращает массив отправленных данных, если был выполнен POST-запрос, либо null.
	 *
	 * @return array|bool
	 */

	public function getPostData()
	{
		switch($this->current_step)
		{
			case 0:
			{
				if(isset($_POST['ClientSelectProductForm']))
				{
					return $_POST['ClientSelectProductForm'];
				}
				return false;
			}
				break;
			case 1:
			{
				if(isset($_POST['ClientSelectGetWayForm']))
				{
					return $_POST['ClientSelectGetWayForm'];
				}
				return false;
			}
				break;
			case 2:
			{
				if(isset($_POST['ClientPersonalDataForm']))
				{
					return $_POST['ClientPersonalDataForm'];
				}
				return false;
			}
				break;
			case 3:
			{
				if(isset($_POST['ClientAddressForm']))
				{
					return $_POST['ClientAddressForm'];
				}
				return false;
			}
				break;
			case 4:
			{
				if(isset($_POST['ClientJobInfoForm']))
				{
					return $_POST['ClientJobInfoForm'];
				}
				return false;
				break;
			}
			case 5:
			{
				if(isset($_POST['ClientSendForm']))
				{
					return $_POST['ClientSendForm'];
				}
				return false;
			}
				break;
			default:
				return false;
				break;

		}
	}

	/*
	 * Переводит обработку форм на следующий шаг
	 *
	 */
	public function nextStep()
	{

		$this->current_step++;
		Yii::app()->session['current_step']=$this->current_step;
		if($this->done_steps<Yii::app()->session['current_step'])
		{
			Yii::app()->session['done_steps']=$this->done_steps=Yii::app()->session['current_step'];
		}

	}

	/**
	 * Выполняет обработку данных формы после проверки.
	 *
	 * @param ClientCreateFormAbstract $model
	 */
	public function formDataProcess($clientData, $oForm)
	{
		/**
		 * @var ClientData $client
		 * @var ClientData $clientData
		 * @var ClientCreateFormAbstract $oForm
		 */
		if(get_class($oForm)==='ClientSelectProductForm')
		{
			Yii::app()->session['product']=$oForm->product;
		}
		elseif(get_class($oForm)==='ClientSelectGetWayForm')
		{
			Yii::app()->session['get_way']=$oForm->get_way;
		}
		elseif(get_class($oForm)==='ClientPersonalDataForm')
		{
			/* проверяем, есть ли в куках информация о клиенте
			 * и сравниваем введенный телефон с телефоном в куках.
			 * в случае успешности восстанавливаем client_id из куки.
			 * иначе создаем нового клиента и сохраняем информацию
			 * о нем в сессию и куку.
			 */

			if(($cookieData = $this->getDataFromCookie('client'))&&($this->compareDataInCookie('client','phone',$oForm->phone)))
			{
				Yii::app()->session['client_id'] = $cookieData['client_id'];
				$this->client_id=Yii::app()->session['client_id'];
			}
			else
			{
				$client=$clientData->addClient($oForm);
				Yii::app()->session['client_id'] = $client->client_id;
				$this->client_id=$client->client_id;
				$data = array('client_id'=>$client->client_id,'phone'=>$client->phone);
				$this->saveDataToCookie('client',$data);
			}

			if($this->client_id)
			{
				$formData=$oForm->getAttributes();
				$formData['product']=Yii::app()->session['product'];
				$formData['get_way']=Yii::app()->session['get_way'];
				$clientData->saveClientDataById($formData,$this->client_id);

				$formData['client_id']=$this->client_id;
				Cookie::saveDataToCookie(get_class($oForm),$formData);
			}
		}
		else
		{
			if($this->client_id)
			{
				$formData=$oForm->getAttributes();
				$clientData->saveClientDataById($formData,$this->client_id);

				$formData['client_id']=$this->client_id;
				Cookie::saveDataToCookie(get_class($oForm),$formData);
			}
		}

		return;
	}

	private function compareDataInCookie($cookieName,$attributeName,$checkValue)
	{
		$dataInCookie = false;
		if(isset(Yii::app()->request->cookies[$cookieName]))
		{
			$cookie = Yii::app()->request->cookies[$cookieName];

			$sDecrypt=CryptArray::decryptVal($cookie);//декриптим куку

			$aDecrypt= @unserialize($sDecrypt);
			if($aDecrypt&&($checkValue == $aDecrypt[$attributeName]))
			{
				$dataInCookie=true;
			}
		}
		return $dataInCookie;
	}

	public function getDataFromCookie($cookieName)
	{
		if(isset(Yii::app()->request->cookies[$cookieName]))
		{
			$cookie = Yii::app()->request->cookies[$cookieName];

			$sDecrypt=CryptArray::decryptVal($cookie);//декриптим куку
			$aDecrypt= @unserialize($sDecrypt);
			return $aDecrypt;
		}
		return false;
	}

	private function saveDataToCookie($cookieName,$data)
	{
		$sEncrypt = serialize($data);
		$cookieData = CryptArray::encryptVal($sEncrypt);

		$cookie = new CHttpCookie($cookieName, $cookieData);
		$cookie->expire = time()+60*60*2;
		Yii::app()->request->cookies[$cookieName] = $cookie;
	}
}
