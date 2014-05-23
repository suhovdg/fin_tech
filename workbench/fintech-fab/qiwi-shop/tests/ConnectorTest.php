<?php

use FintechFab\QiwiShop\Components\Sdk\Curl;
use FintechFab\QiwiShop\Components\Sdk\QiwiGateConnector;

class ConnectorTest extends ShopTestCase
{

	/**
	 * @var Mockery\MockInterface|Curl
	 */
	private $mock;

	public function setUp()
	{
		parent::setUp();
		$this->mock = Mockery::mock('FintechFab\QiwiShop\Components\Sdk\Curl');
	}


	public function testCreateBill()
	{

		$connector = new QiwiGateConnector($this->mock);

		$bill = array(
			'user'     => 'tel:+7910000',
			'amount'   => 123.45,
			'ccy'      => 'RUB',
			'comment'  => 'SomeComment',
			'lifetime' => null,
			'prv_name' => QiwiGateConnector::getConfig('provider.name'),
		);

		$args = array(
			123, 'PUT', $bill
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 0,
						'bill'        => (object)array(
								'bill_id' => 123,
							),
					)
			));

		$isSuccess = $connector->createBill(123, '+7910000', 123.45, 'SomeComment');
		$this->assertTrue($isSuccess, $connector->getError());
	}

	public function testCreateBillFailFormat()
	{

		$connector = new QiwiGateConnector($this->mock);

		$bill = array(
			'user'     => 'tel:+',
			'amount'   => 123.45,
			'ccy'      => 'RUB',
			'comment'  => null,
			'lifetime' => null,
			'prv_name' => QiwiGateConnector::getConfig('provider.name'),
		);

		$args = array(
			123, 'PUT', $bill
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 5,
					)
			));

		$isSuccess = $connector->createBill(123, '+', 123.45);
		$this->assertFalse($isSuccess);
		$this->assertEquals('Неверный формат параметров запроса', $connector->getError());
	}

	public function testCreateBillFailSum()
	{

		$connector = new QiwiGateConnector($this->mock);

		$isSuccess = $connector->createBill(123, '+', 0);
		$this->assertFalse($isSuccess);
		$this->assertEquals('Сумма слишком мала', $connector->getError());
	}

	public function testCheckStatus()
	{

		$connector = new QiwiGateConnector($this->mock);

		$args = array(123);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 0,
						'bill'        => (object)array(
								'status' => 'waiting',
							),
					)
			));

		$isSuccess = $connector->checkStatus(123);
		$this->assertTrue($isSuccess);
		$this->assertEquals('payable', $connector->getStatus());
	}

	public function testCheckStatusFail()
	{

		$connector = new QiwiGateConnector($this->mock);

		$args = array(123);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 210,
						'bill'        => (object)array(
								'status' => 'waiting',
							),
					)
			));

		$isSuccess = $connector->checkStatus(123);
		$this->assertFalse($isSuccess);
		$this->assertEquals('Счет не найден', $connector->getError());
	}

	public function testCancelBill()
	{

		$connector = new QiwiGateConnector($this->mock);

		$reject = array('status' => 'rejected');

		$args = array(
			123, 'PATCH', $reject
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 0,
						'bill'        => (object)array(
								'bill_id' => 123,
							),
					)
			));

		$isSuccess = $connector->cancelBill(123);
		$this->assertTrue($isSuccess);
	}

	public function testCancelBillFail()
	{

		$connector = new QiwiGateConnector($this->mock);

		$reject = array('status' => 'rejected');

		$args = array(
			123, 'PATCH', $reject
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 150,
					)
			));

		$isSuccess = $connector->cancelBill(123);
		$this->assertFalse($isSuccess);
		$this->assertEquals('Ошибка авторизации', $connector->getError());
	}

	public function testPayReturn()
	{

		$connector = new QiwiGateConnector($this->mock);

		$amount = array('amount' => 23);

		$args = array(
			123, 'PUT', $amount, 1
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 0,
					)
			));

		$isSuccess = $connector->payReturn(123, 1, 23);
		$this->assertTrue($isSuccess);
	}

	public function testPayReturnFail()
	{

		$connector = new QiwiGateConnector($this->mock);

		$amount = array('amount' => 23);

		$args = array(
			123, 'PUT', $amount, 1
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 215,
					)
			));

		$isSuccess = $connector->payReturn(123, 1, 23);
		$this->assertFalse($isSuccess);
		$this->assertEquals('Счет с таким bill_id уже существует', $connector->getError());
	}

	public function testPayReturnFailSum()
	{

		$connector = new QiwiGateConnector($this->mock);

		$isSuccess = $connector->payReturn(123, 1, 0);
		$this->assertFalse($isSuccess);
		$this->assertEquals('Сумма слишком мала', $connector->getError());
	}

	public function testCheckReturnStatus()
	{

		$connector = new QiwiGateConnector($this->mock);

		$args = array(
			123, 'GET', null, 1
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 0,
						'refund'      => (object)array(
								'status' => 'processing',
							),
					)
			));

		$isSuccess = $connector->checkReturnStatus(123, 1);
		$this->assertTrue($isSuccess);
		$this->assertEquals('onReturn', $connector->getStatus());
	}

	public function testCheckReturnStatusFail()
	{

		$connector = new QiwiGateConnector($this->mock);

		$args = array(
			123, 'GET', null, 1
		);

		$this->mock
			->shouldReceive('request')
			->withArgs($args)
			->andReturn((object)array(
				'response' => (object)array(
						'result_code' => 210,
					)
			));

		$isSuccess = $connector->checkReturnStatus(123, 1);
		$this->assertFalse($isSuccess);
		$this->assertEquals('Счет не найден', $connector->getError());
	}
}