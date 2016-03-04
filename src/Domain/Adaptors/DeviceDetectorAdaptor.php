<?php namespace Pete001\Agent\Domain\Adaptors;

use Pete001\Agent\Domain\DomainInterface;
use DeviceDetector\DeviceDetector;

/**
 * Adaptor for the device detector library
 */
class DeviceDetectorAdaptor implements DomainInterface
{
	/**
	 * The 3rd party instance
	 *
	 * @var DeviceDetector
	 */
	protected $domain;

	/**
	 * Initialise the 3rd party app
	 *
	 * @param DeviceDetector $domain The device detector instance
	 */
	public function __construct(DeviceDetector $domain)
	{
		$this->domain = $domain;
		$this->domain->discardBotInformation();
		$this->domain->parse();
	}

	/**
	 * Is the agent a desktop
	 *
	 * @return Boolean
	 */
	public function isDesktop()
	{
		return $this->domain->isDesktop();
	}

	/**
	 * Is the agent mobile web
	 *
	 * @return Boolean
	 */
	public function isMobile()
	{
		return $this->domain->isMobile();
	}

	/**
	 * Is the agent a mobile app
	 *
	 * @return Boolean
	 */
	public function isMobileApp()
	{
		return $this->domain->isMobileApp();
	}

	/**
	 * Is the agent a bot
	 *
	 * @return Boolean
	 */
	public function isBot()
	{
		return $this->domain->isBot();
	}
}
