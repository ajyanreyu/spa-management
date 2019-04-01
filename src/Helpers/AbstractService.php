<?php
/**
 * Created by PhpStorm.
 * User: alban
 * Date: 01/04/2019
 * Time: 14:38
 */

namespace App\Helpers;


use Doctrine\ORM\EntityManager;

/**
 * Class AbstractService
 * @package App\Helpers
 * @author Albano Yanes <ajyanreyu@gmaiol.com>
 */
class AbstractService
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * AbstractService constructor.
     * @param EntityManager $entityManager
     * @author Albano Yanes <ajyanreyu@gmaiol.com>
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


}