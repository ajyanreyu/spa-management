<?php
/**
 * Created by PhpStorm.
 * User: alban
 * Date: 01/04/2019
 * Time: 14:40
 */

namespace App\Service;


use App\Entity\Booking;
use App\Entity\Service;
use App\Entity\ServiceSchedule;
use App\Helpers\AbstractService;
use Doctrine\ORM\EntityManager;

class SpaServicesService extends AbstractService
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * find the list of <i>all services</i>
     * @return array
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function findAllService()
    {
        $services = $this->entityManager->getRepository(Service::class)
            ->findAll();
        $serviceList = [];
        foreach ($services as $service) {
            $serviceList[] = [
                'name' => $service->getName(),
                'description' => $service->getDescription(),
                'price' => $service->getPrice()
            ];
        }

        return $serviceList;
    }


    /**
     * Find available service days by date range
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     * @throws \Exception
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function findServiceScheduleByDateRange($from, $to)
    {
        $scheduleList = [];

        $services = $this->entityManager->getRepository(Service::class)
            ->findAll();

        foreach ($services as $service) {
            $serviceSchedule = $this->entityManager->getRepository(ServiceSchedule::class)
                ->findAllByDateRange($from, $to, $service);

            $availableServices = $this->findAvailableService($serviceSchedule);

            $scheduleList [] = [
                'id' => $service->getId(),
                'name' => $service->getName(),
                'description' => $service->getDescription(),
                'price' => $service->getPrice(),
                'availableService' => count($availableServices) > 0 ? $availableServices : null
            ];

        }

        return $scheduleList;
    }


    /**
     * Finds the days that have not been booked for the service schedule
     * @param ServiceSchedule[] $serviceSchedule
     * @return array
     * @throws \Exception
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    private function findAvailableService($serviceSchedule)
    {
        $availableDays = [];
        foreach ($serviceSchedule as $schedule) {
            $booking = $this->entityManager->getRepository(Booking::class)
                ->findBy(
                    [
                        'service' => $schedule->getService(),
                        'date' => new \DateTime($schedule->getDate()->format('Y-m-d')),
                        'time' => $schedule->getServiceStart()
                    ]);

            if (!$booking) {
                $availableDays[] = [
                    'id' => $schedule->getId(),
                    'date' => $schedule->getDate(),
                    'serviceStart' => $schedule->getServiceStart(),
                    'serviceEnd' => $schedule->getServiceEnd()
                ];
            }
        }
        return $availableDays;
    }

}