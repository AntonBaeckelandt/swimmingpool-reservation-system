<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 */
class Subscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_employee", "show_customer", "show_subscription", "show_registration"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_employee", "show_customer", "show_subscription", "show_registration"})
     * @Assert\NotNull
     * @Assert\Type("\DateTimeInterface")
     * @Assert\GreaterThanOrEqual("now")
     */
    private $expirationDate;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="subscription")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_subscription", "show_registration"})
     * @Assert\NotNull
     */
    private $customer;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_employee", "show_customer", "show_subscription", "show_registration"})
     * @Assert\NotNull
     * @Assert\Type("\DateTimeInterface")
     * @Assert\LessThanOrEqual("now")
     */
    private $boughtOn;

    /**
     * @ORM\OneToMany(targetEntity=Registration::class, mappedBy="subscription")
     * @Groups({"show_subscription"})
     */
    private $registrations;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

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

    /**
     * @return Collection|Registration[]
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): self
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations[] = $registration;
            $registration->setSubscription($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getSubscription() === $this) {
                $registration->setSubscription(null);
            }
        }

        return $this;
    }
}
