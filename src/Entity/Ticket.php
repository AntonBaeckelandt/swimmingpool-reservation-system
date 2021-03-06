<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_ticket", "show_registration"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"show_ticket", "show_registration"})
     * @Assert\NotNull
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_ticket", "show_registration"})
     * @Assert\Type("\DateTimeInterface")
     * @Assert\NotNull
     * @Assert\LessThanOrEqual("now")
     */
    private $boughtOn;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_ticket", "show_registration"})
     * @Assert\GreaterThanOrEqual("now")
     */
    private $validOn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBoughtOn(): ?\DateTimeInterface
    {
        return $this->boughtOn;
    }

    public function setBoughtOn(\DateTimeInterface $boughtOn): self
    {
        $this->boughtOn = $boughtOn;

        return $this;
    }

    public function getValidOn(): ?\DateTimeInterface
    {
        return $this->validOn;
    }

    public function setValidOn(\DateTimeInterface $validOn): self
    {
        $this->validOn = $validOn;

        return $this;
    }
}
