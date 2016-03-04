<?php namespace Pete001\Agent\Domain;

/**
 * Generic domain controller
 */
class DomainController extends AbstractController
{
	/**
	 * The domain interface
	 *
	 * @var DomainInterface
	 */
	protected $domain;

	/**
	 * Intialise the controller
	 *
	 * @param DomainInterface $domain The relevant adaptor
	 *
	 * @param Array           $map    The custom domain map
	 */
	public function __construct(DomainInterface $domain, Array $map)
	{
		$this->domain = $domain;
		$this->setMap($map);
	}

	/**
	 * Check if its a desktop
	 *
	 * @return Mixed Integer|False Id if it is, false if not
	 */
	public function isDesktop()
	{
		return $this->domain->isDesktop()
			? $this->mapper(self::DESKTOP)
			: false;
	}

	/**
	 * Check if its mobile web
	 *
	 * @return Mixed Integer|False Id if it is, false if not
	 */
	public function isMobile()
	{
		return $this->domain->isMobile()
			? $this->mapper(self::MOBILE)
			: false;
	}

	/**
	 * Check if its a mobile app
	 *
	 * @return Mixed Integer|False Id if it is, false if not
	 */
	public function isMobileApp()
	{
		return $this->domain->isMobileApp()
			? $this->mapper(self::MOBILEAPP)
			: false;
	}

	/**
	 * Check if its a bot
	 *
	 * @return Mixed Integer|False Id if it is, false if not
	 */
	public function isBot()
	{
		return $this->domain->isBot()
			? $this->mapper(self::BOT)
			: false;
	}

	/**
	 * Helper to return what the domain is if its not a bot
	 *
	 * @return Mixed Integer The relevant id
	 */
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
