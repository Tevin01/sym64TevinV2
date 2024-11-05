<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 160)]
    private ?string $title = null;

    #[ORM\Column(length: 162)]
    private ?string $title_slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $article_date_create = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $article_date_posted = null;

    #[ORM\Column]
    private ?int $published = null;

    /**
     * @var Collection<int, SectionTitle>
     */
    #[ORM\ManyToMany(targetEntity: SectionTitle::class, inversedBy: 'articles')]
    private Collection $stuff;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->stuff = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitleSlug(): ?string
    {
        return $this->title_slug;
    }

    public function setTitleSlug(string $title_slug): static
    {
        $this->title_slug = $title_slug;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getArticleDateCreate(): ?\DateTimeInterface
    {
        return $this->article_date_create;
    }

    public function setArticleDateCreate(\DateTimeInterface $article_date_create): static
    {
        $this->article_date_create = $article_date_create;

        return $this;
    }

    public function getArticleDatePosted(): ?\DateTimeInterface
    {
        return $this->article_date_posted;
    }

    public function setArticleDatePosted(\DateTimeInterface $article_date_posted): static
    {
        $this->article_date_posted = $article_date_posted;

        return $this;
    }

    public function getPublished(): ?int
    {
        return $this->published;
    }

    public function setPublished(int $published): static
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection<int, SectionTitle>
     */
    public function getStuff(): Collection
    {
        return $this->stuff;
    }

    public function addStuff(SectionTitle $stuff): static
    {
        if (!$this->stuff->contains($stuff)) {
            $this->stuff->add($stuff);
        }

        return $this;
    }

    public function removeStuff(SectionTitle $stuff): static
    {
        $this->stuff->removeElement($stuff);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
