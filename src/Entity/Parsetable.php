<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parsetable
 *
 * @ORM\Table(name="ParseTable")
 * @ORM\Entity
 */
class Parsetable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=1000, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=1000, nullable=false)
     */
    private $link;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validuntil", type="datetime", nullable=false)
     */
    private $validuntil;

    /**
     * @var int
     *
     * @ORM\Column(name="countdown", type="integer", nullable=false)
     */
    private $countdown;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=500, nullable=false)
     */
    private $img;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getValiduntil(): ?\DateTimeInterface
    {
        return $this->validuntil;
    }

    public function setValiduntil(\DateTimeInterface $validuntil): self
    {
        $this->validuntil = $validuntil;

        return $this;
    }

    public function getCountdown(): ?int
    {
        return $this->countdown;
    }

    public function setCountdown(int $countdown): self
    {
        $this->countdown = $countdown;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }


}
