<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="service")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    /**
     * @return int|null
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Service
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Service
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float|null
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param $price
     * @return Service
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function setPrice($price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @@return Collection|Booking[]
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    /**
     * @param Booking $booking
     * @return Service
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setService($this);
        }

        return $this;
    }

    /**
     * @param Booking $booking
     * @return Service
     * @author Albano Yanes <ajyanreyu@gmail.com>
     */
    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getService() === $this) {
                $booking->setService(null);
            }
        }

        return $this;
    }


}
