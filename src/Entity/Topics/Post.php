<?php

namespace App\Entity\Topics;

use App\Repository\Topics\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $postAt = null;

    #[ORM\Column(length: 64)]
    private ?string $title = null;

    #[ORM\Column(length: 4096)]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostAt(): ?\DateTimeInterface
    {
        return $this->postAt;
    }

    public function setPostAt(\DateTimeInterface $postAt): self
    {
        $this->postAt = $postAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
