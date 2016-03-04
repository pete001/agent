<?php

use Pete001\Agent\Domain\DomainController;
use Pete001\Agent\Domain\Adaptors\DeviceDetectorAdaptor;
use DeviceDetector\DeviceDetector;
use \Mockery as m;

class DomainTest extends PHPUnit_Framework_TestCase
{
    protected $map = ['Desktop Web' => 1, 'Mobile Web' => 2, 'Mobile App' => 3, 'Bot' => 4, 'Unknown' => 5];
    protected $agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36';

    public function tearDown()
    {
        m::close();
    }

    public function testIntialiseDomain()
    {
        $domain = new DomainController(
            new DeviceDetectorAdaptor(new DeviceDetector),
            $this->map
        );

        $this->assertInstanceOf('Pete001\Agent\Domain\DomainController', $domain);
    }

    public function booleanProvider()
    {
        return [
            ['isDesktop', true, $this->map['Desktop Web']],
            ['isDesktop', false, false],
            ['isMobile', true, $this->map['Mobile Web']],
            ['isMobile', false, false],
            ['isMobileApp', true, $this->map['Mobile App']],
            ['isMobileApp', false, false],
            ['isBot', true, $this->map['Bot']],
            ['isBot', false, false]
        ];
    }

    /**
     * @dataProvider booleanProvider
     */
    public function testIsMethods($method, $return, $result)
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive($method)
            ->once()
            ->andReturn($return)
            ->mock();

        $domain = new DomainController(
            new DeviceDetectorAdaptor($deviceDetector),
            $this->map
        );

        $this->assertEquals($result, $domain->{$method}());
    }

    public function testUnknownMap()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isDesktop')
            ->once()
            ->andReturn(true)
            ->mock();

        $domain = new DomainController(
            new DeviceDetectorAdaptor($deviceDetector),
            ['Invalid' => 11]
        );

        $this->assertEquals(1, $domain->isDesktop());
    }

    public function testGetDomainMobileApp()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isMobileApp')
            ->once()
            ->andReturn(true)
            ->mock();

        $domain = new DomainController(
            new DeviceDetectorAdaptor($deviceDetector),
            $this->map
        );

        $this->assertEquals($this->map['Mobile App'], $domain->getDomain());
    }

    public function testGetDomainMobileWeb()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isMobileApp')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isMobile')
            ->once()
            ->andReturn(true)
            ->mock();

        $domain = new DomainController(
            new DeviceDetectorAdaptor($deviceDetector),
            $this->map
        );

        $this->assertEquals($this->map['Mobile Web'], $domain->getDomain());
    }

    public function testGetDomainDesktop()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isMobileApp')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isMobile')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isDesktop')
            ->once()
            ->andReturn(true)
            ->mock();

        $domain = new DomainController(
            new DeviceDetectorAdaptor($deviceDetector),
            $this->map
        );

        $this->assertEquals($this->map['Desktop Web'], $domain->getDomain());
    }

    public function testGetDomainFail()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isMobileApp')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isMobile')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isDesktop')
            ->once()
            ->andReturn(false)
            ->mock();

        $domain = new DomainController(
            new DeviceDetectorAdaptor($deviceDetector),
            $this->map
        );

        $this->assertEquals($this->map['Unknown'], $domain->getDomain());
    }

    public function testFullConversionCall()
    {
        $domain = new DomainController(
            new DeviceDetectorAdaptor(new DeviceDetector($this->agent)),
            $this->map
        );

        $this->assertFalse($domain->isBot());
        $this->assertEquals(1, $domain->getDomain());
    }
}
