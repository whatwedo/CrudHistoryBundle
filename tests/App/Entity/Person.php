<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use whatwedo\CrudHistoryBundle\Tests\App\Repository\PersonRepository;

#[ORM\Table(name: 'person')]
#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
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
