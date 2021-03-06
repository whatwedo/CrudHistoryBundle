<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use whatwedo\TableBundle\Entity\UserInterface;

/**
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="whatwedo\CrudHistoryBundle\Tests\App\Repository\PersonRepository")
 */
class Person implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\NotNull()
     */
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
