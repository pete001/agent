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
