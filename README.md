# CrudHistoryBundle

## Basic Usage

### config/routes.yaml
```yaml
whatwedo_crud_history_bundle:
  resource: "@whatwedoCrudHistoryBundle/Resources/config/routing.yml"
  prefix: /

```

### src/Definition/History/PersonHistoryDefinition.php

```php
<?php

namespace App\Definition\History;

use App\Entity\Email;
use App\Entity\Person;
use App\Entity\Phone;
use whatwedo\CrudHistoryBundle\Definition\HistoryAssociatedClass;
use whatwedo\CrudHistoryBundle\Definition\HistoryDefinitionInterface;

class PersonHistoryDefinition implements HistoryDefinitionInterface
{
    public function getMainClass(): string
    {
        return Person::class;
    }

    /**
     * @return HistoryAssociatedClass[]
     */
    public function getAssociatedClasses(): array
    {
        /**
        * Classes that are Associated the main Class 
        */
        return [
            new HistoryAssociatedClass(Email::class, []),
            new HistoryAssociatedClass(Phone::class, []),
        ];
    }

    public function getChildDefinitions(): array
    {
        return [];
    }
}
```


### src/Definition/PersonDefinition.php
```php

    public static function getCapabilities(): array
    {
        return array_merge(
            [ HistoryPage::HISTORY ],,
            parent::getCapabilities()
        );

    }
```

## Many To One

### src/Entity/Contact.php
```php
namespace whatwedo\CrudHistoryBundle\Tests\App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use whatwedo\CrudHistoryBundle\Entity\AuditManyToOneTriggerInterface;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact implements \Stringable, AuditManyToOneTriggerInterface
{
    #[ORM\OneToMany(targetEntity: 'Company', mappedBy: 'contacts')]
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }
    
    // ...
    
    public function triggerManyToOne(): array
    {
        $this->getCompany()->triggerAudit();

        return [$this->getCompany()];
    }
}
```

The `triggerManyToOne` should return all entities where the audit has been triggered (`triggerAudit`). This array can contain `null` values. 
This allows you to call getters inside this array and save you some space for null checks.

### src/Entity/Company.php
```php
namespace whatwedo\CrudHistoryBundle\Tests\App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use whatwedo\CrudHistoryBundle\Entity\AuditTriggerInterface;
use whatwedo\CrudHistoryBundle\Entity\AuditTriggerTrait;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company implements AuditTriggerInterface
{
    use AuditTriggerTrait;

    #[ORM\OneToMany(targetEntity: 'Contact', mappedBy: 'company')]
    private Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }
    
    // ...
}
```

### src/Definition/CompanyDefinition.php
```php
namespace whatwedo\CrudHistoryBundle\Tests\App\Definition;

use araise\CrudBundle\Definition\AbstractDefinition;
use whatwedo\CrudHistoryBundle\Definition\HasHistoryDefinition;
use whatwedo\CrudHistoryBundle\Tests\App\Definition\History\CompanyHistoryDefinition;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Company;

class CompanyDefinition extends AbstractDefinition implements HasHistoryDefinition
{
    public static function getEntity(): string
    {
        return Company::class;
    }
    
    public static function getCapabilities(): array
    {
        return array_merge(
            [HistoryPage::HISTORY],
            parent::getCapabilities()
        );
    }
    
    public function getHistoryDefinition(): string
    {
        return CompanyHistoryDefinition::class;
    }
}
```

### App/Definition/History/CompanyHistoryDefinition.php
```php
namespace whatwedo\CrudHistoryBundle\Tests\App\Definition\History;

use whatwedo\CrudHistoryBundle\Definition\HistoryAssociatedClass;
use whatwedo\CrudHistoryBundle\Definition\HistoryDefinitionInterface;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Company;
use whatwedo\CrudHistoryBundle\Tests\App\Entity\Contact;

class CompanyHistoryDefinition implements HistoryDefinitionInterface
{
    public function getMainClass(): string
    {
        return Company::class;
    }

    /**
     * @return HistoryAssociatedClass[]
     */
    public function getAssociatedClasses(): array
    {
        return [
            new HistoryAssociatedClass(Contact::class, []),
        ];
    }

    public function getChildDefinitions(): array
    {
        return [];
    }
}
```