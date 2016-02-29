<?php namespace Pete001\Agent;

/**
 * Abstract class to handle mapping
 */
abstract class AbstractDomain implements DomainInterface
{
	const UNKNOWN = 'Unknown';

	protected $map;

	public function __construct($refs)
	{
		$this->map = $refs;
	}

	public function isDesktop()
	{
		return $this->domain->isDesktop()
			? $this->mapper('Desktop')
			: false;
	}

	public function isMobile()
	{
		return $this->domain->isMobile()
			? $this->mapper('Mobile Web')
			: false;
	}

	public function isMobileApp()
	{
		return $this->domain->isMobileApp()
			? $this->mapper('Mobile App')
			: false;
	}

	public function isBot()
	{
		return $this->domain->isBot()
			? $this->mapper('Bot')
			: false;
	}

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
			: 0;
	}
}
