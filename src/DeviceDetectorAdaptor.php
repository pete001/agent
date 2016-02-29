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

	public function getDomain()
	{
		if ($vDomain = $this->isMobileApp())
		{
			return $vDomain;
		}
		else if ($vDomain = $this->isMobile())
		{
			return $vDomain;
		}
		else if ($vDomain = $this->isDesktop())
		{
			return $vDomain;
		}
		else
		{
			return $this->unknown();
		}
	}
}
