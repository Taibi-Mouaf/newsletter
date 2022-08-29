<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\NewsletterNamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterNamesRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class NewsletterNames
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=NewsletterSubscribers::class, mappedBy="newsletterNames")
     */
    private $newsletterSubscribers;

    public function __construct()
    {
        $this->newsletterSubscribers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, NewsletterSubscribers>
     */
    public function getNewsletterSubscribers(): Collection
    {
        return $this->newsletterSubscribers;
    }

    public function addNewsletterSubscriber(NewsletterSubscribers $newsletterSubscriber): self
    {
        if (!$this->newsletterSubscribers->contains($newsletterSubscriber)) {
            $this->newsletterSubscribers[] = $newsletterSubscriber;
            $newsletterSubscriber->addNewsletterName($this);
        }

        return $this;
    }

    public function removeNewsletterSubscriber(NewsletterSubscribers $newsletterSubscriber): self
    {
        if ($this->newsletterSubscribers->removeElement($newsletterSubscriber)) {
            $newsletterSubscriber->removeNewsletterName($this);
        }

        return $this;
    }
}
