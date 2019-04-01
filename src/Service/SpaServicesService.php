<?php
/**
 * Created by PhpStorm.
 * User: alban
 * Date: 01/04/2019
 * Time: 14:40
 */

namespace App\Service;


use App\Entity\Service;
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
        foreach ($services as $service){
            $serviceList[] = [
                'name' => $service->getName(),
                'description' => $service->getDescription(),
                'price' => $service->getPrice()
            ];
        }

        return $serviceList;
    }

}