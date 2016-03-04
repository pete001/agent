<?php namespace Pete001\Agent\Device;

/**
 * Abstract class to handle device decoding
 */
abstract class AbstractController
{
	const UNKNOWN = 'unknown';

	public function clean_string($string)
	{
		return null === $string
			? self::UNKNOWN
			: preg_replace('/\s+/', ' ', trim($string));
	}

	/**
	 * We need to detect whether its a bot
	 */
	abstract public function isBot();

	/**
	 * We need to understand the client
	 */
	abstract public function getCategory();
}
