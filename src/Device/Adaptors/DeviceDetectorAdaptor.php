<?php namespace Pete001\Agent\Device\Adaptors;

use Pete001\Agent\Device\DeviceInterface;
use DeviceDetector\DeviceDetector;

/**
 * Adaptor for the device detector library
 */
class DeviceDetectorAdaptor implements DeviceInterface
{
	/**
	 * The 3rd party instance
	 *
	 * @var DeviceDetector
	 */
	protected $device;

	/**
	 * Initialise the 3rd party app
	 *
	 * @param DeviceDetector $device The device detector instance
	 */
	public function __construct(DeviceDetector $device)
	{
		$this->device = $device;
		$this->device->discardBotInformation();
		$this->device->parse();
	}

	/**
	 * Is the agent a bot
	 *
	 * @return Boolean
	 */
	public function isBot()
	{
		return $this->device->isBot();
	}

	/**
	 * Return the device category
	 *
	 * @return Mixed String|Null
	 */
	public function getCategory()
	{
		if ($this->device->isDesktop()) {
			return 'desktop';
		} else if ($this->device->isMobile()) {
			return $this->device->isTablet()
				? 'tablet'
				: 'device';
		} else {
			return null;
		}
	}

	/**
	 * Return the OS details
	 *
	 * @return String
	 */
	public function getOs()
	{
		$os = $this->device->getOs();
		return "{$os['name']} {$os['version']}";
	}

	/**
	 * Return the device type
	 *
	 * @return String
	 */
	public function getDevice()
	{
		return "{$this->device->getBrand()} {$this->device->getModel()}";
	}

	/**
	 * Return the browser details
	 *
	 * @return String
	 */
	public function getBrowser()
	{
		$client = $this->device->getClient();
		return "{$client['name']} {$client['version']}";
	}
}
