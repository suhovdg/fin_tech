<?php

/**
 * Class PixelFilter
 */
class PixelFilter extends CFilter
{

	const C_BANKI_RU = 'banki_ru';
	const C_LINKPROFIT = 'linkprofit';
	const C_EPROMO = 'epromo';
	const C_LEADS24 = 'leads24';
	const C_MASTERTARGET = 'mastertarget';
	const C_TOPADW = 'topadw';
	const C_ADMITAD = 'cpamit';
	const C_TRADETRACKER = 'tradetracker';

	// Дополнительные параметры, которые принимаются из GET-запроса, по которому клиент попадает на наш сайт
	public static $aAdditionalFields = array(
		self::C_BANKI_RU   => array(),
		self::C_LINKPROFIT => array(),
		self::C_EPROMO => array(),
		self::C_LEADS24 => array(),
		self::C_MASTERTARGET => array(),
		self::C_TOPADW => array(),
		self::C_ADMITAD => array('cpamit_uid'),
		self::C_ADMITAD => array(),
	);

	public function preFilter($aFilterChain)
	{
		$this->detectLink();

		return true;
	}

	/**
	 * Определяет c какого лидогенератора пришел клиент
	 * В случае успеха устанавливаем двухмесячную Cookie для клиента
	 */
	private function detectLink()
	{
		$sUid = strtolower(Yii::app()->request->getQuery('pk_campaign'));

		// Если не пусто или нет в нашем списке лидогенераторов
		if (!$sUid || !array_key_exists($sUid, self::$aAdditionalFields)) {
			return;
		}

		/** Дополнительные array(переменные => значения) из GET запроса
		 * у каждого могут быть свои
		 * попадут в свойства объекта CHttpCookie
		 */
		$aParams = array();

		// Список дополнительных переменных
		$aFields = self::$aAdditionalFields[$sUid];
		foreach ($aFields as $sFieldName) {
			$aParams[$sFieldName] = Yii::app()->request->getQuery($sFieldName);
		}

		$oCookie = new CHttpCookie('lead_generator', $sUid, $aParams);

		$oCookie->expire = SiteParams::getTime() + SiteParams::CTIME_MONTH;
		$oCookie->httpOnly = true;

		Yii::app()->request->cookies->add('lead_generator', $oCookie);

	}

}