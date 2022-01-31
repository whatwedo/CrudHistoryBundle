## Basic Usage

config/routes.yaml
```yaml
whatwedo_crud_auditor_bundle:
    resource: "@whatwedoCrudHistoryBundle/Resources/config/routing.yml"
    prefix: /

```

src/Definition/History/PersonHistoryDefinition.php
```php
<?php

namespace App\Definition\History;

use App\Entity\Email;
use App\Entity\Person;
use App\Entity\Phone;
use whatwedo\CrudHistoryBundle\Definition\HistoryAsscoiatedClass;
use whatwedo\CrudHistoryBundle\Definition\HistoryDefinitionInterface;

class PersonHistoryDefinition implements HistoryDefinitionInterface
{
    public function getMainClass(): string
    {
        return Person::class;
    }

    /**
     * @return HistoryAsscoiatedClass[]
     */
    public function getAssociatedClasses(): array
    {
        return [
            new HistoryAsscoiatedClass(Email::class, []),
            new HistoryAsscoiatedClass(Phone::class, []),
        ];
    }

    public function getChildDefinitions(): array
    {
        return [];
    }
}


```



src/Definition/PersonDefinition.php
```php

    public static function getCapabilities(): array
    {
        return array_merge(
            [ 'history' ],
            parent::getCapabilities()
        );

    }



```


