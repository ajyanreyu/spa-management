<?php
/**
 * Created by PhpStorm.
 * User: alban
 * Date: 01/04/2019
 * Time: 14:57
 */

namespace App\Tests\Service;

use App\Entity\Service;
use App\Service\SpaServicesService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SpaServicesServiceTest extends WebTestCase
{
    private $entityManager = null;

    private $repository = null;

    /**
     * Mocks the entity manager and the repository
     * @author Albano Yanes <aj.work4live@gmail.com>
     */
    public function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'getRepository'
                ]
            )
            ->getMock();

        $this->repository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'find',
                    'findAll',
                ]
            )
            ->getMock();
    }

    /**
     * @test
     * @author Albano Yanes <aj.work4live@gmail.com>
     */
    public function testFindAllService()
    {
        $mockedService = new Service();
        $mockedService->setName('four-hand massage');
        $mockedService->setDescription('it takes two therapists and the magma room');
        $mockedService->setPrice(25.72);

        $mockedServiceList = [
            $mockedService
        ];

        $this->repository->expects($this->any())
            ->method('findAll')
            ->willReturn($mockedServiceList);

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->repository);

        $spaService = new SpaServicesService($this->entityManager);

        $result = $spaService->findAllService();

        $this->assertEquals($mockedService->getName(), $result[0]['name']);
        $this->assertEquals($mockedService->getDescription(), $result[0]['description']);
        $this->assertEquals($mockedService->getPrice(), $result[0]['price']);

    }
}
