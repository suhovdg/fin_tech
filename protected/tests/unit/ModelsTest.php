<?php
/**
 * Created by JetBrains PhpStorm.
 * User: m.novikov
 * Date: 02.08.13
 * Time: 10:44
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class ModelsTest
 */

class ModelsTest extends CTestCase
{


	public function testCheckBirthdayValid()
	{

		$aPostData = array(
			'birthday' => '22.12.1991',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertEmpty($oForm->getError('birthday'), print_r($oForm->getError('birthday'), true));
		//$this->assertNotEmpty($oForm->getErrors()['email']);

	}

	public function testCheckBirthdayNonValid()
	{

		$aPostData = array(
			'birthday' => '30.11.2000',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('birthday'));

	}

	public function testCheckPassportValid()
	{

		$aPostData = array(
			'birthday'      => '29.02.1994',
			'passport_date' => '01.03.2008',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertEmpty($oForm->getError('passport_date'), print_r($oForm->getError('passport_date'), true));


	}

	public function testCheckPassportValid2()
	{

		$aPostData = array(
			'birthday'      => '10.10.1945',
			'passport_date' => '29.02.2000',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertEmpty($oForm->getError('passport_date'), print_r($oForm->getError('passport_date'), true));


	}


	public function testCheckPassportNonValid()
	{

		$aPostData = array(
			'birthday'      => '10.10.1945',
			'passport_date' => '29.02.2005',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('passport_date'));


	}

	public function testCheckPassportNonValid2()
	{

		$aPostData = array(
			'birthday'      => '10.10.1945',
			'passport_date' => '22.02.1990',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('passport_date'));

	}

	public function testCheckPassportNonValid3()
	{

		$aPostData = array(
			'birthday'      => '08.08.2000',
			'passport_date' => '08.08.2005',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('passport_date'));

	}

	public function testCheckPassportNonValid4()
	{

		$aPostData = array(
			'birthday'      => '20.07.2045',
			'passport_date' => '11.09.1910',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('passport_date'));

	}

	public function testCheckPassportValid3()
	{

		$aPostData = array(
			'birthday'      => '22.02.1945',
			'passport_date' => '08.08.2013',
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertEmpty($oForm->getError('passport_date'), print_r($oForm->getError('passport_date'), true));
	}


	public function testCheckPhoneValid()
	{

		$aPostData = array(
			'phone' => '9' . substr((rand(1000000000, 1999999999)), 1),
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertEmpty($oForm->getError('phone'), print_r($oForm->getError('phone'), true));
	}

	public function testCheckPhoneNoValid()
	{

		$aPostData = array(
			'phone' => rand(0, 8) . substr((rand(1000000000, 1999999999)), 1),
		);


		$oForm = new ClientPersonalDataForm();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('phone'), print_r($oForm->getError('phone'), true));
	}

	public function testCheckPhonesNoValid()
	{

		$sPhone = '9' . substr((rand(1000000000, 1999999999)), 1);
		$sJobPhone = '9' . substr((rand(1000000000, 1999999999)), 1);
		$sRelOnePhone = $sPhone;
		$sFriendsPhone = $sJobPhone;

		$aPostData = array(
			'phone'               => $sPhone,
			'job_phone'           => $sJobPhone,
			'relatives_one_phone' => $sRelOnePhone,
			'friends_phone'       => $sFriendsPhone
		);


		$oForm = new ClientFullForm2();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('phone'));
		$this->assertNotEmpty($oForm->getError('job_phone'));
		$this->assertNotEmpty($oForm->getError('friends_phone'));
		$this->assertNotEmpty($oForm->getError('relatives_one_phone'));

		$sPhone = '9' . substr((rand(1000000000, 1999999999)), 1);
		$sJobPhone = $sPhone;
		$sRelOnePhone = $sPhone;
		$sFriendsPhone = $sJobPhone;

		$aPostData = array(
			'phone'               => $sPhone,
			'job_phone'           => $sJobPhone,
			'relatives_one_phone' => $sRelOnePhone,
			'friends_phone'       => $sFriendsPhone
		);


		$oForm = new ClientFullForm2();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('phone'));
		$this->assertNotEmpty($oForm->getError('job_phone'));
		$this->assertNotEmpty($oForm->getError('friends_phone'));
		$this->assertNotEmpty($oForm->getError('relatives_one_phone'));
	}

	/**
	 * Проверка обязательности ФИО и телефона друга, если рабочий телефон одинаковый с мобильным
	 */
	public function testFriendsOnJobPhone()
	{


		$sPhone = '+7 926 266 26 26';
		$sJobPhone = $sPhone;
		$sFriendsPhone = '';
		$sFriendsFio = '';

		$aPostData = array(
			'phone'         => $sPhone,
			'job_phone'     => $sJobPhone,
			'friends_phone' => $sFriendsPhone,
			'friends_fio'   => $sFriendsFio
		);

		$oForm = new ClientFullForm2();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertNotEmpty($oForm->getError('friends_phone'));
		$this->assertNotEmpty($oForm->getError('friends_fio'));

		$sJobPhone = '9151001010';

		$aPostData = array(
			'phone'         => $sPhone,
			'job_phone'     => $sJobPhone,
			'friends_phone' => $sFriendsPhone,
			'friends_fio'   => $sFriendsFio
		);

		$oForm = new ClientFullForm2();
		$oForm->setAttributes($aPostData);

		$oForm->validate();

		$this->assertEmpty($oForm->getError('friends_phone'), print_r($oForm->getError('friends_phone'), true));
		$this->assertEmpty($oForm->getError('friends_fio'), print_r($oForm->getError('friends_fio'), true));
	}
}