<?php

namespace Markenwerk\SlackClient;

/**
 * Class SlackClientTest
 *
 * @package Markenwerk\SlackClient
 */
class SlackClientTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var string
	 */
	private $subdomain;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var string
	 */
	private $channel;

	/**
	 * @var string
	 */
	private $member;

	/**
	 * SlackClientTest constructor.
	 *
	 * @param string $name
	 * @param array $data
	 * @param string $dataName
	 */
	public function __construct($name = null, array $data = array(), $dataName = '')
	{
		$this->subdomain = getenv('SLACK_SUBDOMAIN');
		$this->token = getenv('SLACK_API_TOKEN');
		$this->channel = getenv('SLACK_TEST_CHANNEL');
		$this->member = getenv('SLACK_TEST_MEMBER');
		parent::__construct($name, $data, $dataName);
	}

	public function testPostToChannel()
	{
		if (!$this->subdomain || !$this->token || !$this->channel) {
			$this->markTestSkipped('Post to channel test was skipped. Environment vars missing.');
		}
		$this->buildClient()->postToChannel($this->channel, $this->buildMessage());
	}

	public function testPostToMember()
	{
		if (!$this->subdomain || !$this->token || !$this->member) {
			$this->markTestSkipped('Post to channel test was skipped. Environment vars missing.');
		}
		$this->buildClient()->postToMember($this->member, $this->buildMessage());
	}

	public function testMisconfigureClient1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$client = new SlackClient();
		$client->setSubdomainName(123);
	}

	public function testMisconfigureClient2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$client = new SlackClient();
		$client->setToken(123);
	}

	public function testMisconfigureClient3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$client = new SlackClient();
		$client->setUsername(array('123'));
	}

	public function testMisconfigureClient4()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$client = new SlackClient();
		$client->postToMember(new \stdClass(), new SlackMessage());
	}

	public function testMisconfigureClient5()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$client = new SlackClient();
		$client->postToChannel(fopen(__FILE__, 'r'), new SlackMessage());
	}

	public function testMisconfigureAttachment1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$attachment = new SlackAttachment();
		$attachment->setFields(array('123'));
	}

	public function testMisconfigureAttachment2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$attachment = new SlackAttachment();
		$attachment->setColor(new \stdClass());
	}

	public function testMisconfigureAttachment3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$attachment = new SlackAttachment();
		$attachment->setFallback(true);
	}

	public function testMisconfigureAttachment4()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$attachment = new SlackAttachment();
		$attachment->setPretext(null);
	}

	public function testMisconfigureAttachment5()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$attachment = new SlackAttachment();
		$attachment->setText(PHP_INT_MAX);
	}

	public function testMisconfigureMessage1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$message = new SlackMessage();
		$message->setText(123);
	}

	public function testMisconfigureMessage2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$message = new SlackMessage();
		$message->setAttachments(array('123'));
	}

	public function testMisconfigureMessage3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$message = new SlackMessage();
		$message->setIconUrl(false);
	}

	public function testMisconfigureMessage4()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$message = new SlackMessage();
		$message->setUnfurlLinks('banana');
	}

	public function testMisconfigureMessage5()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$message = new SlackMessage();
		$message->setUnfurlMedia('circus shot');
	}

	/**
	 * @return SlackClient
	 */
	private function buildClient()
	{
		$client = new SlackClient();
		$client
			->setSubdomainName($this->subdomain)
			->setToken($this->token)
			->setUsername('PHP SlackClient');
		return $client;
	}

	/**
	 * @return SlackMessage
	 */
	private function buildMessage()
	{
		$message = new SlackMessage();
		$message
			->setText('A basic Slack client library providing simple posting to Slack channels using the webhook API.')
			->setIconUrl('https://avatars2.githubusercontent.com/u/5921253?v=3&s=200')
			->setUnfurlLinks(true)
			->setUnfurlMedia(true);

		$attachment = new SlackAttachment();
		$attachment
			->setText('A basic Slack client library providing simple posting to Slack channels using the webhook API.')
			->setPretext('A basic Slack client library.')
			->setFallback('A basic Slack client library providing simple posting to Slack channels using the webhook API.')
			->setColor(SlackAttachment::COLOR_WARNING);

		$shortAttachmentField = new SlackAttachmentField();
		$shortAttachmentField
			->setTitle('Short field')
			->setValue('Some chars')
			->setShort(true);

		$anotherShortAttachmentField = new SlackAttachmentField();
		$anotherShortAttachmentField
			->setTitle('Short field')
			->setValue('Some chars')
			->setShort(true);

		$attachmentField = new SlackAttachmentField();
		$attachmentField
			->setTitle('Regular field')
			->setValue('Some more chars')
			->setShort(false);

		$anotherAttachmentField = new SlackAttachmentField();
		$anotherAttachmentField
			->setTitle('Regular field')
			->setValue('Some more chars')
			->setShort(false);

		$attachment
			->addField($shortAttachmentField)
			->addField($anotherShortAttachmentField)
			->addField($attachmentField)
			->addField($anotherAttachmentField)
			->removeField($anotherAttachmentField)
			->removeField($anotherAttachmentField)
			->clearFields()
			->setFields(array(
				$shortAttachmentField,
				$anotherShortAttachmentField,
				$attachmentField,
				$anotherAttachmentField
			));

		$message
			->addAttachment($attachment)
			->removeAttachment($attachment)
			->removeAttachment($attachment)
			->setAttachments(array($attachment));

		fwrite(STDOUT, 'Message has ' . $message->countAttachments() . ' attachments.');

		return $message;
	}

}
