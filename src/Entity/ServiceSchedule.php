<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceScheduleRepository")
 */
class ServiceSchedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\Column(name="service_start", type="time")
     */
    private $serviceStart;
    /**
     * @ORM\Column(name="service_end", type="time")
     */
    private $serviceEnd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", nullable=false)
     */
    private $service;

    /**
     * @param int $id
     * @author Albano Yanes <ajyanreyu@gmail.com>
     * @return ServiceSchedule
     */
    public function setId($id): ServiceSchedule
    {
        $this->id = $id;

        return $this;
    }



    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return \DateTimeInterface|null
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return ServiceSchedule
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getServiceStart(): ?\DateTimeInterface
    {
        return $this->serviceStart;
    }

    /**
     * @param $serviceStart
     * @return ServiceSchedule
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function setServiceStart($serviceStart): self
    {
        $this->serviceStart = $serviceStart;

        return $this;
    }


    /**
     * @return \DateTimeInterface|null
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getServiceEnd(): ?\DateTimeInterface
    {
        return $this->serviceEnd;
    }

    /**
     * @param \DateTimeInterface $serviceEnd
     * @return ServiceSchedule
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function setServiceEnd(\DateTimeInterface $serviceEnd): self
    {
        $this->serviceEnd = $serviceEnd;

        return $this;
    }

    /**
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service): void
    {
        $this->service = $service;
    }


}
