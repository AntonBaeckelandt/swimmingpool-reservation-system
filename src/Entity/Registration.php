<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=RegistrationRepository::class)
 */
class Registration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_registration", "show_subscription"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"show_registration", "show_subscription"})
     * @Assert\NotNull
     * @Assert\LessThanOrEqual("now")
     */
    private $check_in_timestamp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show_registration", "show_subscription"})
     * @Assert\LessThanOrEqual("now")
     */
    private $check_out_timestamp;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_registration", "show_subscription"})
     * @Assert\NotNull
     * @Assert\Range(min=0, max=1, notInRangeMessage = "Type must be between 0 and 1",
     * )
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=AdmissionBracelet::class, inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_registration", "show_subscription"})
     * @Assert\NotNull
     */
    private $bracelet;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_registration", "show_subscription"})
     * @Assert\NotNull
     */
    private $registeredBy;

    /**
     * @ORM\OneToOne(targetEntity=Ticket::class, cascade={"persist", "remove"})
     * @Groups({"show_registration"})
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity=Subscription::class, inversedBy="registrations")
     * @Groups({"show_registration"})
     */
    private $subscription;

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

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

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
}
