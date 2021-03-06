<?php

namespace PhpConsole\Test;

class PsrLogger extends \Psr\Log\Test\LoggerInterfaceTest {

	/** @var \PhpConsole\Connector|\PHPUnit_Framework_MockObject_MockObject */
	protected $connector;
	/** @var \PhpConsole\ErrorMessage[]|\PhpConsole\DebugMessage[] */
	public $sentMessages = array();

	protected function setUp() {
		parent::setUp();
		$this->connector = $this->initConnectorMock();
		$this->sentMessages = array();
	}

	protected function initConnectorMock() {
		$connector = $this->getMockBuilder('\PhpConsole\Connector')
			->disableOriginalConstructor()
			->setMethods(array('sendMessage', 'isActiveClient'))
			->getMock();

		$connector->expects($this->any())
			->method('isActiveClient')
			->will($this->returnValue(true));

		$test = $this;
		$connector->expects($this->any())
			->method('sendMessage')
			->will($this->returnCallback(function (\PhpConsole\Message $message) use ($test) {
				$test->sentMessages[] = $message;
			}));

		return $connector;
	}

	/**
	 * @return \Psr\Log\LoggerInterface
	 */
	function getLogger() {
		return new \PhpConsole\PsrLogger($this->connector);
	}

	/**
	 * This must return the log messages in order with a simple formatting: "<LOG LEVEL> <MESSAGE>"
	 *
	 * Example ->error('Foo') would yield "error Foo"
	 *
	 * @return string[]
	 */
	function getLogs() {
		$messagesData = array();
		foreach($this->sentMessages as $message) {
			if($message instanceof \PhpConsole\ErrorMessage) {
				$messagesData[] = array_search($message->class, \PhpConsole\PsrLogger::$errorsLevels) . ' ' . $message->data;
			}
			elseif($message instanceof \PhpConsole\DebugMessage) {
				$messagesData[] = array_search($message->tags[0], \PhpConsole\PsrLogger::$debugLevels) . ' ' . $message->data;
			}
		}
		return $messagesData;
	}

	public function testContextDataIsDumped() {
		/** @var \PhpConsole\Dumper $dumper */
		$dumper = $this->connector->getDumper();
		$string = str_repeat('x', $dumper->itemSizeLimit + 1);
		$this->getLogger()->info('{var}', array('var' => $string));
		$messagesData = $this->getLogs();
		$this->assertEquals('info ' . $dumper->dump($string), $messagesData[0]);
	}

	public function testExceptionContextVarIsDispatched() {
		$this->getLogger()->critical('error', array('exception' => new \Exception('exception message')));
		$this->assertEquals(1, count($this->sentMessages));
		/** @var \PhpConsole\ErrorMessage $message */
		$message = $this->sentMessages[0];
		$this->assertInstanceOf('PhpConsole\ErrorMessage', $message);
		$message->data = 'exception message';
	}
}
