<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=RegistrationRepository::class)
 */
class Registration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_registration"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"show_registration"})
     */
    private $check_in_timestamp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show_registration"})
     */
    private $check_out_timestamp;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_registration"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=AdmissionBracelet::class, inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_registration"})
     */
    private $bracelet;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_registration"})
     */
    private $registeredBy;

    /**
     * @ORM\OneToOne(targetEntity=Subscription::class, cascade={"persist", "remove"})
     */
    private $subscription;

    /**
     * @ORM\OneToOne(targetEntity=Ticket::class, cascade={"persist", "remove"})
     */
    private $ticket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckInTimestamp(): ?\DateTimeInterface
    {
        return $this->check_in_timestamp;
    }

    public function setCheckInTimestamp(\DateTimeInterface $check_in_timestamp): self
    {
        $this->check_in_timestamp = $check_in_timestamp;

        return $this;
    }

    public function getCheckOutTimestamp(): ?\DateTimeInterface
    {
        return $this->check_out_timestamp;
    }

    public function setCheckOutTimestamp(?\DateTimeInterface $check_out_timestamp): self
    {
        $this->check_out_timestamp = $check_out_timestamp;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBracelet(): ?AdmissionBracelet
    {
        return $this->bracelet;
    }

    public function setBracelet(?AdmissionBracelet $bracelet): self
    {
        $this->bracelet = $bracelet;

        return $this;
    }

    public function getRegisteredBy(): ?Employee
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(?Employee $RegisteredBy): self
    {
        $this->registeredBy = $RegisteredBy;

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
