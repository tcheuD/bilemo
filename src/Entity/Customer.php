<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @UniqueEntity(
 *     "email",
 *     message="This email already exist."
 * )
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "show"})
     * @Assert\NotBlank(message = "The value for firstname should not be blank")
     * @Assert\Length(
     *     min="2",
     *     max="255",
     *     minMessage = "The firstname must be at least {{ limit }} characters long",
     *     maxMessage = "The firstname cannot be longer than {{ limit }} characters"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "show"})
     * @Assert\NotBlank(message = "The value for name should not be blank")
     * @Assert\Length(
     *     min="2",
     *     max="255",
     *     minMessage = "The name must be at least {{ limit }} characters long",
     *     maxMessage = "The name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"show"})
     * @Assert\NotBlank(message = "The value for email should not be blank")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     * @Assert\NotBlank(message = "The value for adress should not be blank")
     * @Assert\Length(
     *     min="2",
     *     max="255",
     *     minMessage = "The adress must be at least {{ limit }} characters long",
     *     maxMessage = "The adress cannot be longer than {{ limit }} characters"
     * )
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "show"})
     * @Assert\NotBlank(message = "The value for city should not be blank")
     * @Assert\Length(
     *     min="2",
     *     max="50",
     *     minMessage = "The city must be at least {{ limit }} characters long",
     *     maxMessage = "The city cannot be longer than {{ limit }} characters"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     */
    private $postalCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /** @Groups({"list"}) */
    private $customerList;

    /** @Groups({"show"}) */
    private $customerShow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCustomerList(): array
    {
        return [
            '_links' => [
                'self' => 'GET: /api/customer/'.$this->getId(),
                'delete' => 'DELETE: /api/customer/'.$this->getId()
            ]
        ];
    }

    public function getCustomerShow(): array
    {
        return [
            '_links' => [
                'list all customers' => '/api/product/',
                'self' => ' GET: /api/customer/'.$this->getId(),
                'delete' => 'DELETE: /api/customer/'.$this->getId()
            ]
        ];
    }
}
