<?php

namespace Owldesign\SlackClient;

/**
 * Class SlackAttachment
 *
 * @package Owldesign\SlackClient
 */
class SlackAttachment implements SlackAttachmentInterface
{

	const COLOR_GOOD = 'good';
	const COLOR_WARNING = 'warning';
	const COLOR_DANGER = 'danger';

	/**
	 * @var string
	 */
	private $fallback = '';

	/**
	 * @var string
	 */
	private $text = null;

	/**
	 * @var string
	 */
	private $pretext = null;

	/**
	 * Can either be one of 'good', 'warning', 'danger', or any hex color code
	 *
	 * @var string
	 */
	private $color = self::COLOR_GOOD;

	/**
	 * @var SlackAttachmentFieldInterface[]
	 */
	private $fields = array();

	/**
	 * @param string $color
	 * @return $this
	 */
	public function setColor($color)
	{
		if (!is_string($color)) {
			$argumentType = (is_object($color)) ? get_class($color) : gettype($color);
			throw new \InvalidArgumentException('Expected the color as string. Got ' . $argumentType);
		}
		$this->color = $color;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getColor()
	{
		return $this->color;
	}

	/**
	 * @param string $fallback
	 * @return $this
	 */
	public function setFallback($fallback)
	{
		if (!is_string($fallback)) {
			$argumentType = (is_object($fallback)) ? get_class($fallback) : gettype($fallback);
			throw new \InvalidArgumentException('Expected the fallback text as string. Got ' . $argumentType);
		}
		$this->fallback = $fallback;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFallback()
	{
		return $this->fallback;
	}

	/**
	 * @param SlackAttachmentFieldInterface[] $fields
	 * @return $this
	 */
	public function setFields(array $fields)
	{
		foreach ($fields as $field) {
			if (!$field instanceof SlackAttachmentFieldInterface) {
				$argumentType = (is_object($field)) ? get_class($field) : gettype($field);
				throw new \InvalidArgumentException(
					'Expected the attachment fields as array of SlackAttachmentInterface implementations. Found '
					. $argumentType
				);
			}
		}
		$this->fields = $fields;
		return $this;
	}

	/**
	 * @param SlackAttachmentFieldInterface $field
	 * @return $this
	 */
	public function addField(SlackAttachmentFieldInterface $field)
	{
		$this->fields[] = $field;
		return $this;
	}

	/**
	 * @param SlackAttachmentFieldInterface $field
	 * @return $this
	 */
	public function removeField(SlackAttachmentFieldInterface $field)
	{
		$fieldCount = count($this->fields);
		for ($i = 0; $i < $fieldCount; $i++) {
			if ($this->fields[$i] == $field) {
				unset($this->fields[$i]);
				$this->fields = array_values($this->fields);
				return $this;
			}
		}
		return $this;
	}

	/**
	 * @return $this
	 */
	public function clearFields()
	{
		$this->fields = array();
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasFields()
	{
		return count($this->fields) > 0;
	}

	/**
	 * @return int
	 */
	public function countFields()
	{
		return count($this->fields);
	}

	/**
	 * @return SlackAttachmentFieldInterface[]
	 */
	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @param string $pretext
	 * @return $this
	 */
	public function setPretext($pretext)
	{
		if (!is_string($pretext)) {
			$argumentType = (is_object($pretext)) ? get_class($pretext) : gettype($pretext);
			throw new \InvalidArgumentException('Expected the pretext as string. Got ' . $argumentType);
		}
		$this->pretext = $pretext;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPretext()
	{
		return $this->pretext;
	}

	/**
	 * @param string $text
	 * @return $this
	 */
	public function setText($text)
	{
		if (!is_string($text)) {
			$argumentType = (is_object($text)) ? get_class($text) : gettype($text);
			throw new \InvalidArgumentException('Expected the text as string. Got ' . $argumentType);
		}
		$this->text = $text;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		$attachment = array(
			'fallback' => $this->getFallback(),
			'color' => $this->getColor(),
		);
		if (!is_null($this->getText())) {
			$attachment['text'] = $this->getText();
		}
		if (!is_null($this->getPretext())) {
			$attachment['pretext'] = $this->getPretext();
		}
		foreach ($this->getFields() as $field) {
			if (!isset($attachment['fields'])) {
				$attachment['fields'] = array();
			}
			$attachment['fields'][] = $field->toArray();
		}
		return $attachment;
	}

}
