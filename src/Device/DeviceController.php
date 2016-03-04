<?php namespace Pete001\Agent\Device;

/**
 * Generic domain controller
 */
class DeviceController extends AbstractController
{
	/**
	 * The device interface
	 *
	 * @var DeviceInterface
	 */
	protected $device;

	/**
	 * Intialise the controller
	 *
	 * @param DeviceInterface $device The relevant adaptor
	 */
	public function __construct(DeviceInterface $device)
	{
		$this->device = $device;
	}

	/**
	 * Check if its a bot
	 *
	 * @return Boolean
	 */
	public function isBot()
	{
		return (bool) $this->device->isBot();
	}

	/**
	 * Return whether its desktop|device|tablet
	 *
	 * @return String|Null
	 */
	public function getCategory()
	{
		return $this->clean_string($this->device->getCategory());
	}

	/**
	 * Return the OS details
	 *
	 * @return String
	 */
	public function getOs()
	{
		return $this->clean_string($this->device->getOs());
	}

	/**
	 * Return the device details
	 *
	 * @return String
	 */
	public function getDevice()
	{
		return $this->clean_string($this->device->getDevice());
	}

	/**
	 * Return the browser details
	 *
	 * @return String
	 */
	public function getBrowser()
	{
		return $this->clean_string($this->device->getBrowser());
	}
}
