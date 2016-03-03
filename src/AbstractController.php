<?php namespace Pete001\Agent;

/**
 * Abstract class to handle mapping
 */
abstract class AbstractController
{
	const UNKNOWN = 'Unknown';
	const UNKNOWN_ID = 1;

	const DESKTOP = 'Desktop Web';
	const MOBILE = 'Mobile Web';
	const MOBILEAPP = 'Mobile App';
	const BOT = 'Bot';

	protected $map;

	protected function mapper($domain)
	{
		return array_key_exists($domain, $this->map)
			? $this->map[$domain]
			: $this->unknown();
	}

	protected function unknown()
	{
		return array_key_exists(self::UNKNOWN, $this->map)
			? $this->map[self::UNKNOWN]
			: self::UNKNOWN_ID;
	}

	public function setMap(Array $map)
	{
		return $this->map = $map;
	}

	abstract public function getDomain();
}
