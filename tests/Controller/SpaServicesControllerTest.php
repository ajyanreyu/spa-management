<?php

namespace App\Tests\Controller;

use App\Controller\SpaServicesController;
use App\Helpers\AbstractAppSpaControllerTest;
use App\Service\SpaServicesService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class SpaServicesControllerTest extends AbstractAppSpaControllerTest
{
    private $container = null;

    public function setUp()
    {
        $this->container = $this->getMockBuilder(ContainerInterface::class)
            ->getMock();
    }

    public function testFindService()
    {

        $this->container->expects($this->any())
            ->method('get')
            ->with('app.service.spa_services')
            ->will($this->returnCallback(
                function () {
                    $mockResult = [
                        [
                            'name' => 'four-hand massage',
                            'description' => 'it takes two therapists and the magma room',
                            'price' => 25.70
                        ]
                    ];
                    return $this->getMockAppSpaService('findAllService', $mockResult, SpaServicesService::class);
                }
            ));

        $controller = new SpaServicesController();
        $controller->setContainer($this->container);

        $request = $this->mockRequest(null, null);
        $response = $controller->findService($request);
        $mockResult = [
            [
                'name' => 'four-hand massage',
                'description' => 'it takes two therapists and the magma room',
                'price' => 25.70
            ]
        ];
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $this->assertSame($mockResult, $response->getData());

    }
}
