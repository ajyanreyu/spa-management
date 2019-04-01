<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class SpaServicesController extends FOSRestController
{
    /**
     * @Rest\Get("/service", name="spa_service")
     */
    public function findService()
    {
        $serviceList = $this->get('app.service.spa_services')->findAllService();
        return View::create($serviceList, Response::HTTP_OK);

    }
}
