<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Tests\App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use whatwedo\CrudHistoryBundle\Entity\AuditManyToOneTriggerInterface;
use whatwedo\CrudHistoryBundle\Tests\App\Repository\ContactRepository;

#[ORM\Table(name: 'contact')]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact implements \Stringable, AuditManyToOneTriggerInterface
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $name = null;

    /**
     * Many Groups have Many Members.
     */
    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'contacts')]
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function triggerManyToOne(): array
    {
        $this->getCompany()->triggerAudit();

        return [$this->getCompany()];
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }
}
