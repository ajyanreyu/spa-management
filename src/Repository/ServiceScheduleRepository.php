<?php

namespace App\Repository;

use App\Entity\Service;
use App\Entity\ServiceSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServiceSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceSchedule[]    findAll()
 * @method ServiceSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceScheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServiceSchedule::class);
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @param Service $service
     * @return ServiceSchedule[] | null
     * @throws \Exception
     */
    public function findAllByDateRange($from, $to, $service)
    {
        return $this->createQueryBuilder('service_schedule')
            ->where('service_schedule.date between :from and :to')
            ->andWhere('service_schedule.service = :service')
            ->setParameters(
                [
                    'from' => new \DateTime($from->format('Y-m-d') . '00:00:00'),
                    'to' => new \DateTime($to->format('Y-m-d') . '23:59:00'),
                    'service' => $service
                ]
            )
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?ServiceSchedule
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
