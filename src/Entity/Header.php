<?php

namespace App\Entity;

use App\Repository\HeaderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use  Symfony\Component\Validator\Constraints as Assert;
use  Vich\UploaderBundle\Mapping\Annotation as Vich;


#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: HeaderRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Header
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max: 50)]
    private ?string $fullName = null;

    #[Vich\UploadableField(mapping: 'header_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
    
    #[ORM\PrePersist]
    public function  setUpdateAtValue()
    {
        $this->updateAt = new \DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    
/**
 * Shadow and bone
 *
 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile;
    */ 
    public function setImageFile(?File $imageFile = null) :void
    {
        $this->imageFile = $imageFile;

        if(null !== $imageFile)
        {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile() : ?File
    {
    return $this->imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName = null): self
    {
        $this->imageName = $imageName;
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
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
