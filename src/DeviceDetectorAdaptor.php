<?php namespace Pete001\Agent;

use DeviceDetector\DeviceDetector;

/**
 * Adaptor for the device detector library
 */
class DeviceDetectorAdaptor extends AbstractDomain
{
	protected $domain;

	public function __construct($agent, $refs)
	{
		$this->domain = new DeviceDetector($agent);
		$this->domain->parse();
		parent::__construct($refs);
	}
}
