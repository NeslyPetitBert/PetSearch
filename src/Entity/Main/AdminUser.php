<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminUserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Un autre utilisateur s'est déjà inscrit avec l'adresse email {{ value }} merci de vous enregistrer avec une autre adresse email"
 * )
 * @UniqueEntity(
 *     fields={"lastName", "firstName"},
 *     errorPath="firstName",
 *     message="Le prénom {{ value }} est déjà utilisé avec le nom de famille indiqué."
 * )
 */
class AdminUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez votre nom pour continuer"
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez votre prénom pour continuer"
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @Assert\Email(
     *     message = "L'adresse email '{{ value }}' n'est pas une adresse email valide."
     * )
     * @Assert\NotBlank(
     *     message="Vous avez oublié de saisir votre adresse email"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank(
     *     message="Choisissez un mot de passe.."
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Le mot de passe de confirmation n'est pas correcte")
     */
    private $passwordConfirm;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getFullName(){
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * @return mixed
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * @param mixed $passwordConfirm
     * @return AdminUser
     */
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
        return $this;
    }


    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Returns the roles granted to the AdminUser.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the AdminUser object
     * is created.
     *
     * @return array (Role|string)[] The AdminUser roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // give everyone ROLE_USER!
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }
        return $roles;
    }

    /**
     * Returns the password used to authenticate the AdminUser.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->hash;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {

    }

    /**
     * Returns the username used to authenticate the AdminUser.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;

    }

    /**
     * Removes sensitive data from the AdminUser.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
}
