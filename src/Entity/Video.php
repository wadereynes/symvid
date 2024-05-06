<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index as Index;
/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 * @ORM\Table(name="videos", indexes={@Index(name="title_idx", columns={"title"})})
 */
class Video
{
    public const videoForNotLoggedIn = 113716040;
    public const VimeoPath = 'https://player.vimeo.com/video/';

    public const perPage = 5; // for pagination
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="videos")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="video")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likedVideos")
     * @ORM\JoinTable(name="likes")
     */
    private $usersThatLike;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="dislikedVideos")
     * @ORM\JoinTable(name="dislikes")
     */
    private $userThatDontLike;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->usersThatLike = new ArrayCollection();
        $this->userThatDontLike = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getVimeoId($user): ?string
    {
        if($user)
        {
            return $this->path;
        }
        else return self::VimeoPath.self::videoForNotLoggedIn;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setVideo($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getVideo() === $this) {
                $comment->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersThatLike(): Collection
    {
        return $this->usersThatLike;
    }

    public function addUsersThatLike(User $usersThatLike): self
    {
        if (!$this->usersThatLike->contains($usersThatLike)) {
            $this->usersThatLike[] = $usersThatLike;
        }

        return $this;
    }

    public function removeUsersThatLike(User $usersThatLike): self
    {
        $this->usersThatLike->removeElement($usersThatLike);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserThatDontLike(): Collection
    {
        return $this->userThatDontLike;
    }

    public function addUserThatDontLike(User $userThatDontLike): self
    {
        if (!$this->userThatDontLike->contains($userThatDontLike)) {
            $this->userThatDontLike[] = $userThatDontLike;
        }

        return $this;
    }

    public function removeUserThatDontLike(User $userThatDontLike): self
    {
        $this->userThatDontLike->removeElement($userThatDontLike);

        return $this;
    }
}

