<?php

namespace App\Entity;

use App\Repository\QualityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use  Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: QualityRepository::class)]
class Quality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\OneToMany(mappedBy: 'quality', targetEntity: QualityContent::class)]
    private Collection $qualityContents;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->UpdatedAt = new \DateTimeImmutable();
        $this->qualityContents = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    /**
     * @return Collection<int, QualityContent>
     */
    public function getQualityContents(): Collection
    {
        return $this->qualityContents;
    }

    public function addQualityContent(QualityContent $qualityContent): self
    {
        if (!$this->qualityContents->contains($qualityContent)) {
            $this->qualityContents->add($qualityContent);
            $qualityContent->setQuality($this);
        }

        return $this;
    }

    public function removeQualityContent(QualityContent $qualityContent): self
    {
        if ($this->qualityContents->removeElement($qualityContent)) {
            // set the owning side to null (unless already changed)
            if ($qualityContent->getQuality() === $this) {
                $qualityContent->setQuality(null);
            }
        }

        return $this;
    }
}
