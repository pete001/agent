<?php

use Pete001\Agent\Device\DeviceController;
use Pete001\Agent\Device\Adaptors\DeviceDetectorAdaptor;
use DeviceDetector\DeviceDetector;
use \Mockery as m;

class DeviceTest extends PHPUnit_Framework_TestCase
{
    protected $agent = [
        'desktop' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36',
        'mobile' => 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-ca; LG-P505R Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
        'tablet' => 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25'
    ];

    public function tearDown()
    {
        m::close();
    }

    public function testIntialiseDevice()
    {
        $device = new DeviceController(
            new DeviceDetectorAdaptor(new DeviceDetector)
        );

        $this->assertInstanceOf('Pete001\Agent\Device\DeviceController', $device);
    }

    public function booleanProvider()
    {
        return [
            ['isBot', true, true],
            ['isBot', false, false],
            ['getOs', ['name'=>'Safari', 'version'=>'    2.0'], 'Safari 2.0']
        ];
    }

    /**
     * @dataProvider booleanProvider
     */
    public function testSimpleControllerMethods($method, $return, $result)
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive($method)
            ->once()
            ->andReturn($return)
            ->mock();

        $device = new DeviceController(
            new DeviceDetectorAdaptor($deviceDetector)
        );

        $this->assertEquals($result, $device->{$method}());
    }

    public function testGetDevice()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('getBrand')
            ->once()
            ->andReturn('LG')
            ->shouldReceive('getModel')
            ->once()
            ->andReturn('Shiny')
            ->mock();

        $device = new DeviceController(
            new DeviceDetectorAdaptor($deviceDetector)
        );

        $this->assertEquals('LG Shiny', $device->getDevice());
    }

    public function testGetBrowser()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('getClient')
            ->once()
            ->andReturn(['name' => 'Chrome', 'version' => '33'])
            ->mock();

        $device = new DeviceController(
            new DeviceDetectorAdaptor($deviceDetector)
        );

        $this->assertEquals('Chrome 33', $device->getBrowser());
    }

    public function testGetCategoryDesktop()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isDesktop')
            ->once()
            ->andReturn(true)
            ->mock();

        $device = new DeviceController(
            new DeviceDetectorAdaptor($deviceDetector)
        );

        $this->assertEquals('desktop', $device->getCategory());
    }

    public function testGetCategoryTablet()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isDesktop')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isMobile')
            ->once()
            ->andReturn(true)
            ->shouldReceive('isTablet')
            ->once()
            ->andReturn(true)
            ->mock();

        $device = new DeviceController(
            new DeviceDetectorAdaptor($deviceDetector)
        );

        $this->assertEquals('tablet', $device->getCategory());
    }

    public function testGetCategoryMobile()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isDesktop')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isMobile')
            ->once()
            ->andReturn(true)
            ->shouldReceive('isTablet')
            ->once()
            ->andReturn(false)
            ->mock();

        $device = new DeviceController(
            new DeviceDetectorAdaptor($deviceDetector)
        );

        $this->assertEquals('device', $device->getCategory());
    }

    public function testGetCategoryFail()
    {
        $deviceDetector = m::mock('DeviceDetector\DeviceDetector');
        $deviceDetector->shouldReceive('parse','discardBotInformation')
            ->once()
            ->shouldReceive('isDesktop')
            ->once()
            ->andReturn(false)
            ->shouldReceive('isMobile')
            ->once()
            ->andReturn(false)
            ->mock();

        $device = new DeviceController(
            new DeviceDetectorAdaptor($deviceDetector)
        );

        $this->assertEquals('unknown', $device->getCategory());
    }

    public function booleanProviderAgents()
    {
        return [
            [$this->agent['desktop'], 'getCategory', 'desktop'],
            [$this->agent['tablet'], 'getCategory', 'tablet'],
            [$this->agent['mobile'], 'getCategory', 'device'],
            [$this->agent['tablet'], 'isBot', false],
            [$this->agent['tablet'], 'getDevice', 'AP iPad'],
            [$this->agent['tablet'], 'getBrowser', 'Mobile Safari 6.0'],
            [$this->agent['tablet'], 'getOS', 'iOS 6.0'],
        ];
    }

    /**
     * @dataProvider booleanProviderAgents
     */
    public function testDeviceDetector($agent, $method, $result)
    {
        $device = new DeviceController(
            new DeviceDetectorAdaptor(new DeviceDetector($agent))
        );

        $this->assertEquals($result, $device->{$method}());
    }}
