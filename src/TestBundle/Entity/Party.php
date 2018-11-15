<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Juskiewicz\Geolocation\Model\CoordinatesInterface;

/**
 * Event
 *
 * @ORM\Table(name="party")
 * @ORM\Entity(repositoryClass="TestBundle\Repository\PartyRepository")
 */
class Party
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300)
     * @Assert\NotBlank()
     * @Assert\Length(max=300)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(max=255)
     */
    private $email;

    /**
     * @var CoordinatesInterface
     *
     * @ORM\Column(type="point")
     */
    private $point;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_from", type="datetime")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual("+7 days")
     */
    private $fromAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_to", type="datetime")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual("+7 days")
     * @Assert\Expression(
     *     "value >= this.getFromAt()",
     *     message="Data końca musi być większa bądź równa dacie startu"
     * )
     */
    private $toAt;

    public function __construct()
    {
        $this->fromAt = new \DateTime();
        $this->toAt = new \DateTime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Party
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Party
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Party
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Party
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param CoordinatesInterface $point
     *
     * @return Party
     */
    public function setPoint(CoordinatesInterface $point): self
    {
        $this->point = $point;

        return $this;
    }

    /**
     * @return CoordinatesInterface
     */
    public function getPoint(): CoordinatesInterface
    {
        return $this->point;
    }

    /**
     * Set fromAt.
     *
     * @param \DateTime $fromAt
     *
     * @return Party
     */
    public function setFromAt(\DateTime $fromAt): self
    {
        $this->fromAt = $fromAt;

        return $this;
    }

    /**
     * Get fromAt.
     *
     * @return \DateTime
     */
    public function getFromAt(): \DateTime
    {
        return $this->fromAt;
    }

    /**
     * Set toAt.
     *
     * @param \DateTime $toAt
     *
     * @return Party
     */
    public function setToAt(\DateTime $toAt): self
    {
        $this->toAt = $toAt;

        return $this;
    }

    /**
     * Get toAt.
     *
     * @return \DateTime
     */
    public function getToAt(): \DateTime
    {
        return $this->toAt;
    }
}
