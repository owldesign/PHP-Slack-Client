<?php

namespace Owldesign\SlackClient;

/**
 * Class SlackAttachmentField
 *
 * @package Owldesign\SlackClient
 */
class SlackAttachmentField implements SlackAttachmentFieldInterface
{

	/**
	 * @var string
	 */
	private $title = '';

	/**
	 * @var string
	 */
	private $value = '';

	/**
	 * @var bool
	 */
	private $short = false;

	/**
	 * @param bool $short
	 * @return $this
	 */
	public function setShort($short)
	{
		$this->short = $short;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getShort()
	{
		return $this->short;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $value
	 * @return $this
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'title' => $this->getTitle(),
			'value' => $this->getValue(),
			'short' => $this->getShort(),
		);
	}

}
