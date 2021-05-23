<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="fk_iduseremetteur_message", columns={"id_user_emetteur"}), @ORM\Index(name="fk_iddiscussion_message", columns={"id_discussion"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="contenu", type="string", length=255, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_msg", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateMsg;

    /**
     * @var \Discussion
     *
     * @ORM\ManyToOne(targetEntity="Discussion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_discussion", referencedColumnName="id")
     * })
     */
    private $idDiscussion;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_emetteur", referencedColumnName="id")
     * })
     */
    private $idUserEmetteur;
    
    public function __construct(User $currentUser)
    {
        $this->idUserEmetteur = $currentUser;
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateMsg(): ?\DateTimeInterface
    {
        return $this->dateMsg;
    }

    public function setDateMsg(\DateTimeInterface $dateMsg): self
    {
        $this->dateMsg = $dateMsg;

        return $this;
    }

    public function getIdDiscussion(): ?Discussion
    {
        return $this->idDiscussion;
    }

    public function setIdDiscussion(?Discussion $idDiscussion): self
    {
        $this->idDiscussion = $idDiscussion;

        return $this;
    }

    public function getIdUserEmetteur(): ?User
    {
        return $this->idUserEmetteur;
    }

    public function setIdUserEmetteur(?User $idUserEmetteur): self
    {
        $this->idUserEmetteur = $idUserEmetteur;

        return $this;
    }

    

    

   

}
