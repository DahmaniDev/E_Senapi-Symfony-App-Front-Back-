<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @Vich\Uploadable
 * Evenement
 *
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 *
 */
class Evenement
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "titre est obligatoire")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="emplacement", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "emplacement est obligatoire")
     */
    private $emplacement;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     * @Assert\NotBlank(message = "prix est obligatoire")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $imageEvent;
    /**
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="imageEvent")
     * @var File|null
     */
    private $imageFile;


    /**
     * @var string
     *
     * @ORM\Column(name="date_event", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="date est obligatoire")
     */
    private $dateEvent;



    /**
     * @var string
     *
     * @ORM\Column(name="fondation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="fondation est obligatoire")
     */
    private $fondation;


    /**
     * @CaptchaAssert\ValidCaptcha(
     *      message = "CAPTCHA validation failed, try again."
     * )
     * @Assert\NotBlank(message="Captcha est obligatoire")
     */
    protected $captchaCode;


    /**
     * @var int
     *
     * @ORM\Column(name="nbMaxParticipants", type="integer", nullable=false)
     * @Assert\NotBlank(message="nombre maximale est obligatoire")
     */
    private $nbmaxparticipants;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="durée est obligatoire")
     */
    private $duree;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateEvent(): ?string
    {
        return $this->dateEvent;
    }

    public function setDateEvent(string $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }



    public function getFondation(): ?string
    {
        return $this->fondation;
    }

    public function setFondation(string $fondation): self
    {
        $this->fondation = $fondation;

        return $this;
    }

    public function getNbmaxparticipants(): ?int
    {
        return $this->nbmaxparticipants;
    }

    public function setNbmaxparticipants(int $nbmaxparticipants): self
    {
        $this->nbmaxparticipants = $nbmaxparticipants;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }

    /**
     * @return string|null
     */
    public function getImageEvent(): ?string
    {
        return $this->imageEvent;
    }

    /**
     * @param string|null $imageEvent
     */
    public function setImageEvent(?string $imageEvent): void
    {
        $this->imageEvent = $imageEvent;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }
}
