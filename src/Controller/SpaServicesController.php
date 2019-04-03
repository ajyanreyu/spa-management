<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


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

    /**
     * Find the available services according to a range of dates obtained from the query param
     * <i>It is defined as format of the Query Param the unix timestamp</i>
     * @Rest\Get("/service/schedule", name="service_schedule")
     * @Rest\QueryParam(name="from", requirements="\d+", nullable=false, default="null", description="lower date range")
     * @Rest\QueryParam(name="to", requirements="\d+", nullable=false, default="null", description="upper date range")
     * @param Request $request
     * @return View
     * @throws \Exception
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function findScheduleByDateRange(Request $request)
    {
        $fromDate = $request->get('from');
        $toDate = $request->get('to');
        if ($fromDate && $toDate) {
            $fromDate = new \DateTime("@$fromDate");
            $toDate = new \DateTime("@$toDate");
            $scheduleList = $this->get('app.service.spa_services')->findServiceScheduleByDateRange($fromDate, $toDate);
            return View::create($scheduleList, Response::HTTP_OK);
        } else {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Missing parameters');
        }
    }



}
