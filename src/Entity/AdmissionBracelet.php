<?php

namespace App\Entity;

use App\Repository\AdmissionBraceletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=AdmissionBraceletRepository::class)
 */
class AdmissionBracelet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_bracelet", "show_registration", "show_subscription"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Registration::class, mappedBy="bracelet", orphanRemoval=true)
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
            $registration->setBracelet($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getBracelet() === $this) {
                $registration->setBracelet(null);
            }
        }

        return $this;
    }

    public function isInUse()
    {

    }

}
