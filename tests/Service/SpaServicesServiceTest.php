<?php
/**
 * Created by PhpStorm.
 * User: alban
 * Date: 01/04/2019
 * Time: 14:57
 */

namespace App\Tests\Service;

use App\Entity\Booking;
use App\Entity\Service;
use App\Entity\ServiceSchedule;
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
                    'findBy',
                    'findAll',
                    'findAllByDateRange'
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

    public function testFindServiceScheduleByDateRange()
    {
        $mockedService = new Service();
        $mockedService->setId(1);
        $mockedService->setName('four-hand massage');
        $mockedService->setDescription('it takes two therapists and the magma room');
        $mockedService->setPrice(25.72);

        $mockedServiceList = [$mockedService];


        $mockedServiceSchedule = new ServiceSchedule();

        $mockedServiceSchedule->setId(1);

        $starService = new \DateTime('11:00:00');
        $mockedServiceSchedule->setServiceStart($starService);

        $date = new \DateTime('2019-05-01');
        $mockedServiceSchedule->setService(new \DateTime('13:00:00'));
        $mockedServiceSchedule->setDate($date);
        $mockedServiceSchedule->setService($mockedService);


        $mockedServiceScheduleList = [$mockedServiceSchedule];

        $mockedBooking = new Booking();
        $mockedBooking->setId(1);
        $mockedBooking->setClientName('Pancho');
        $mockedBooking->setDate(new \DateTime('now'));
        $mockedBooking->setTime($starService);

        $mockedBookingList = [$mockedBooking];

        $this->repository->expects($this->any())
            ->method('findAll')
            ->willReturn($mockedServiceList);

        $this->repository->expects($this->any())
            ->method('findAllByDateRange')
            ->willReturn($mockedServiceScheduleList);

        $this->repository->expects($this->any())
            ->method('findAllByDateRange')
            ->willReturn($mockedBookingList);

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->repository);

        $spaService = new SpaServicesService($this->entityManager);
        $today = new \DateTime('now');
        $from = new \DateTime($today->format('Y') . '-01-01');
        $to = new \DateTime($today->format('Y') . '12-31');

        $result = $spaService->findServiceScheduleByDateRange($from, $to);


        $this->assertEquals($mockedService->getId(), $result[0]['id']);
        $this->assertEquals($mockedService->getName(), $result[0]['name']);
        $this->assertEquals($mockedService->getDescription(), $result[0]['description']);
        $this->assertEquals($mockedService->getPrice(), $result[0]['price']);

        $this->assertArrayHasKey('availableService', $result[0]);

        $this->assertEquals($mockedServiceSchedule->getId(), $result[0]['availableService'][0]['id']);
        $this->assertEquals($mockedServiceSchedule->getServiceStart(), $result[0]['availableService'][0]['serviceStart']);
        $this->assertEquals($mockedServiceSchedule->getServiceEnd(), $result[0]['availableService'][0]['serviceEnd']);


    }
}
