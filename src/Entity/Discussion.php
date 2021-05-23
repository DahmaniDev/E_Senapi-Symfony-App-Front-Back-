<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discussion
 *
 * @ORM\Table(name="discussion", indexes={@ORM\Index(name="fk_iduser2_discussion", columns={"id_user2"}), @ORM\Index(name="fk_iduser1_discussion", columns={"id_user1"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DiscussionRepository")
 */
class Discussion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_discussion", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateDiscussion;

    /**
     * @var \User
     *
     * 
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user1", referencedColumnName="id")
     * })
     */
    private $idUser1;

    /**
     * @var \User
     *
     * 
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user2", referencedColumnName="id")
     * })
     */
    private $idUser2;

    public function __construct(int $id,User $currentUser)
    {  

        $this->id = $id;
        $this->idUser1 = $currentUser;
    }

   
    public function __toString() 
{
    return (string) $this->id; 
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?int
    {
        $this->id=$id;
        return $this->id;
    }

    public function getDateDiscussion(): ?\DateTimeInterface
    {
        return $this->dateDiscussion;
    }

    public function setDateDiscussion(\DateTimeInterface $dateDiscussion): self
    {
        $this->dateDiscussion = $dateDiscussion;

        return $this;
    }

    public function getIdUser1(): ?User
    {
        return $this->idUser1;
    }

    public function setIdUser1(?User $idUser1): self
    {
        $this->idUser1 = $idUser1;

        return $this;
    }

    public function getIdUser2(): ?User
    {
        return $this->idUser2;
    }

    public function setIdUser2(?User $idUser2): self
    {
        $this->idUser2 = $idUser2;

        return $this;
    }
   


}
