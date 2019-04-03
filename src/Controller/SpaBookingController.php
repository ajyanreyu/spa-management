<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SpaBookingController extends FOSRestController
{
    /**
     * @Rest\Post("/booking", name="booking")
     * @param Request $request
     * @return View
     * @throws \HttpException
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function createBooking(Request $request)
    {
        try {
            $jsonBooking = json_decode($request->getContent());
            if ($jsonBooking) {
                $booking = $this->get('app.service.spa_booking')->createBooking($jsonBooking);
                return View::create($booking, Response::HTTP_OK);
            } else {
                throw new \Exception('JSON missing or invalid');
            }
        } catch (\Exception $exception) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }


    }
}
