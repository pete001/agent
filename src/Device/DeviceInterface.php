<?php namespace Pete001\Agent\Device;

/**
 * Generic interface for device decoding
 */
interface DeviceInterface
{
	public function isBot();

	public function getCategory();

	public function getOs();

	public function getDevice();

	public function getBrowser();
}
