<?php
/**
 * Created by PhpStorm.
 * User: alban
 * Date: 01/04/2019
 * Time: 15:59
 */

namespace App\Helpers;


use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AbstractAppSpaControllerTest extends TestCase
{

    /**
     * Mocks any spa service with any function
     * @param string $methodName
     * @param mixed $returnValue
     * @param $className
     * @return null|\PHPUnit_Framework_MockObject_MockObject
     * @author Albano Yanes <albano.yanes@atos.net>
     */
    protected function getMockAppSpaService($methodName, $returnValue, $className)
    {
        $mockedAppSpaService = null;
        $mockedAppSpaService = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->setMethods([$methodName])
            ->getMock();


        $mockedAppSpaService->expects($this->any())
            ->method($methodName)
            ->will($this->returnValue($returnValue));

        return $mockedAppSpaService;
    }

    /**
     * Mock request http
     * @param array | null $param
     * @param string | null $content
     * @return Request
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    protected function mockRequest($param, $content)
    {
        return new Request($param ? $param : [], [], [], [], [], [], $content);
    }



}