<?php

namespace Owldesign\SlackClient;

/**
 * Class SlackMessage
 *
 * @package Owldesign\SlackClient
 */
class SlackMessage implements SlackMessageInterface
{

	/**
	 * @var string
	 */
	private $text;

	/**
	 * @var SlackAttachmentInterface[]
	 */
	private $attachments;

	/**
	 * @var string
	 */
	private $iconUrl = null;

	/**
	 * @var bool
	 */
	private $unfurlLinks = true;

	/**
	 * @var bool
	 */
	private $unfurlMedia = true;

	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
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
	 * @return SlackAttachmentInterface[]
	 */
	public function getAttachments()
	{
		return $this->attachments;
	}

	/**
	 * @param SlackAttachmentInterface[] $attachments
	 * @return $this
	 */
	public function setAttachments(array $attachments)
	{
		foreach ($attachments as $attachment) {
			if (!$attachment instanceof SlackAttachmentInterface) {
				$argumentType = (is_object($attachment)) ? get_class($attachment) : gettype($attachment);
				throw new \InvalidArgumentException(
					'Expected the attachments as array of SlackAttachmentInterface implementations. Found '
					. $argumentType
				);
			}
		}
		$this->attachments = $attachments;
		return $this;
	}

	/**
	 * @param SlackAttachmentInterface $attachment
	 * @return $this
	 */
	public function addAttachment(SlackAttachmentInterface $attachment)
	{
		$this->attachments[] = $attachment;
		return $this;
	}

	/**
	 * @param SlackAttachment $attachment
	 * @return $this
	 */
	public function removeAttachment(SlackAttachment $attachment)
	{
		$attachmentCount = count($this->attachments);
		for ($i = 0; $i < $attachmentCount; $i++) {
			if ($this->attachments[$i] == $attachment) {
				unset($this->attachments[$i]);
				$this->attachments = array_values($this->attachments);
				return $this;
			}
		}
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasAttachments()
	{
		return count($this->attachments) > 0;
	}

	/**
	 * @return int
	 */
	public function countAttachments()
	{
		return count($this->attachments);
	}

	/**
	 * @return string
	 */
	public function getIconUrl()
	{
		return $this->iconUrl;
	}

	/**
	 * @param string $iconUrl
	 * @return $this
	 */
	public function setIconUrl($iconUrl)
	{
		if (!is_string($iconUrl)) {
			$argumentType = (is_object($iconUrl)) ? get_class($iconUrl) : gettype($iconUrl);
			throw new \InvalidArgumentException('Expected the icon URL as string. Got ' . $argumentType);
		}
		if (filter_var($iconUrl, FILTER_VALIDATE_URL) === false) {
			throw new \InvalidArgumentException('The icon URL is invalid.');
		}
		$this->iconUrl = $iconUrl;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getUnfurlLinks()
	{
		return $this->unfurlLinks;
	}

	/**
	 * @param bool $unfurlLinks
	 * @return $this
	 */
	public function setUnfurlLinks($unfurlLinks)
	{
		if (!is_bool($unfurlLinks)) {
			$argumentType = (is_object($unfurlLinks)) ? get_class($unfurlLinks) : gettype($unfurlLinks);
			throw new \InvalidArgumentException('Expected the unfurl links setting as boolean. Got ' . $argumentType);
		}
		$this->unfurlLinks = $unfurlLinks;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getUnfurlMedia()
	{
		return $this->unfurlMedia;
	}

	/**
	 * @param bool $unfurlMedia
	 * @return $this
	 */
	public function setUnfurlMedia($unfurlMedia)
	{
		if (!is_bool($unfurlMedia)) {
			$argumentType = (is_object($unfurlMedia)) ? get_class($unfurlMedia) : gettype($unfurlMedia);
			throw new \InvalidArgumentException('Expected the unfurl media setting as boolean. Got ' . $argumentType);
		}
		$this->unfurlMedia = $unfurlMedia;
		return $this;
	}

}
