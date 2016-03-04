<?php namespace Pete001\Agent\Domain;

/**
 * Abstract class to handle mapping
 */
abstract class AbstractController
{
	/**
	 * Default values
	 */
	const UNKNOWN    = 'Unknown';
	const UNKNOWN_ID = 1;

	/**
	 * Identifiers for domains
	 */
	const DESKTOP    = 'Desktop Web';
	const MOBILE     = 'Mobile Web';
	const MOBILEAPP  = 'Mobile App';
	const BOT        = 'Bot';

	/**
	 * The domain map, which is title => id
	 *
	 * @var Array
	 */
	protected $map;

	/**
	 * Set the domain map
	 *
	 * @param Array $map Custom domain map
	 */
	public function setMap(Array $map)
	{
		return $this->map = $map;
	}

	/**
	 * Handles mapping the domain to the id
	 *
	 * @param String $domain The domain title
	 *
	 * @return Integer       The relevant domain id
	 */
	protected function mapper($domain)
	{
		return array_key_exists($domain, $this->map)
			? $this->map[$domain]
			: $this->unknown();
	}

	/**
	 * Unknown domain title handling
	 *
	 * @return Integer The unknown id
	 */
	protected function unknown()
	{
		return array_key_exists(self::UNKNOWN, $this->map)
			? $this->map[self::UNKNOWN]
			: self::UNKNOWN_ID;
	}

	/**
	 * Get domain is a helper to return the non bot id
	 */
	abstract public function getDomain();
}
