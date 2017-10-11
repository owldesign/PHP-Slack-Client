<?php

namespace Owldesign\SlackClient;

/**
 * Interface SlackAttachmentInterface
 *
 * @package Owldesign\SlackClient
 */
interface SlackAttachmentInterface
{

	/**
	 * @return SlackAttachmentFieldInterface[]
	 */
	public function getFields();

	/**
	 * @return array
	 */
	public function toArray();

}
