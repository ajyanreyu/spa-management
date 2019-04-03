<?php
/**
 * Created by PhpStorm.
 * User: alban
 * Date: 03/04/2019
 * Time: 10:22
 */

namespace App\Service;


use App\Entity\Booking;
use App\Entity\Service;
use App\Entity\ServiceSchedule;
use App\Helpers\AbstractService;
use Doctrine\ORM\EntityManager;

class SpaBookingService extends AbstractService
{

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * Create booking by json.If the json does not have the necessary parameters, an exception is executed.
     * @param $booking
     * @return Booking
     * @throws \Exception
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function createBooking($booking)
    {
        if (isset($booking, $booking->service->id, $booking->date, $booking->time, $booking->clientName)) {
            $service = $this->entityManager->getRepository(Service::class)
                ->find($booking->service->id);
            $date = new \DateTime($booking->date);
            $time = new \DateTime($booking->time);
            $serviceSchedule = $this->entityManager->getRepository(ServiceSchedule::class)
                ->findBy(
                    [
                        'service' => $service,
                        'date' => new  $date,
                        'serviceStart' => $time
                    ]
                );
            $registeredBooking = $this->entityManager->getRepository(Booking::class)
                ->findBy(
                    [
                        'date' => $date,
                        'time' => $time,
                        'service' => $service
                    ]
                );

            if (count($serviceSchedule) == 0 && count($registeredBooking) == 0) {
                $newBooking = new Booking();
                $newBooking->setService($service);
                if (isset($booking->comment)) {
                    $newBooking->setComment($booking->comment);
                }
                $newBooking->setClientName($booking->clientName);
                $newBooking->setDate($date);
                $newBooking->setTime($time);
                $newBooking->setPrice($booking->price);
                $this->entityManager->persist($newBooking);
                $this->entityManager->flush();
            } else {
                throw new \Exception('Day and hours reserved');
            }
        } else {
            throw new \Exception('Invalid JSON');
        }

        return $newBooking;

    }

}