<?php namespace Pete001\Agent;

/**
 * Generic domain controller
 */
class DomainController extends AbstractController
{
	protected $domain;

	public function __construct(DomainInterface $domain, Array $map)
	{
		$this->domain = $domain;
		$this->setMap($map);
	}

	public function isDesktop()
	{
		return $this->domain->isDesktop()
			? $this->mapper(self::DESKTOP)
			: false;
	}

	public function isMobile()
	{
		return $this->domain->isMobile()
			? $this->mapper(self::MOBILE)
			: false;
	}

	public function isMobileApp()
	{
		return $this->domain->isMobileApp()
			? $this->mapper(self::MOBILEAPP)
			: false;
	}

	public function isBot()
	{
		return $this->domain->isBot()
			? $this->mapper(self::BOT)
			: false;
	}

	public function getDomain()
	{
		if ($result = $this->isMobileApp())
		{
			return $result;
		}
		else if ($result = $this->isMobile())
		{
			return $result;
		}
		else if ($result = $this->isDesktop())
		{
			return $result;
		}
		else
		{
			return $this->unknown();
		}
	}
}
