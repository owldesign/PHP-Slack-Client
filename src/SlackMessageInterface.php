<?php

namespace Owldesign\SlackClient;

/**
 * Interface SlackMessageInterface
 *
 * @package Owldesign\SlackClient
 */
interface SlackMessageInterface
{

	/**
	 * @return string
	 */
	public function getText();

	/**
	 * @return SlackAttachmentInterface[]
	 */
	public function getAttachments();

	/**
	 * @return bool
	 */
	public function hasAttachments();

	/**
	 * @return string
	 */
	public function getIconUrl();

	/**
	 * @return bool
	 */
	public function getUnfurlLinks();

	/**
	 * @return bool
	 */
	public function getUnfurlMedia();

}
