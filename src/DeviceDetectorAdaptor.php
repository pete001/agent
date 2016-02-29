<?php namespace Pete001\Agent;

use DeviceDetector\DeviceDetector;

/**
 * Adaptor for the device detector library
 */
class DeviceDetectorAdaptor implements DomainInterface
{
	protected $domain;

	public function __construct($agent)
	{
		$this->domain = new DeviceDetector($agent);
		$this->domain->parse();
	}

	public function isDesktop()
	{
		return $this->domain->isDesktop();
	}

	public function isMobile()
	{
		return $this->domain->isMobile();
	}

	public function isMobileApp()
	{
		return $this->domain->isMobileApp();
	}

	public function isBot()
	{
		return $this->domain->isBot();
	}
}
