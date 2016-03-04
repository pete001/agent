<?php namespace Pete001\Agent\Domain;

/**
 * Generic interface for domain decoding
 */
interface DomainInterface
{
	public function isDesktop();

	public function isMobile();

	public function isMobileApp();

	public function isBot();
}
