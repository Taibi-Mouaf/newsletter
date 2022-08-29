<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\NewsletterSubscribersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterSubscribersRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("email", message="Email already used")
 */
class NewsletterSubscribers
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=NewsletterNames::class, inversedBy="newsletterSubscribers")
     */
    private $newsletterNames;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    public function __construct()
    {
        $this->newsletterNames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, NewsletterNames>
     */
    public function getNewsletterNames(): Collection
    {
        return $this->newsletterNames;
    }

    public function addNewsletterName(NewsletterNames $newsletterName): self
    {
        if (!$this->newsletterNames->contains($newsletterName)) {
            $this->newsletterNames[] = $newsletterName;
        }

        return $this;
    }

    public function removeNewsletterName(NewsletterNames $newsletterName): self
    {
        $this->newsletterNames->removeElement($newsletterName);

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
