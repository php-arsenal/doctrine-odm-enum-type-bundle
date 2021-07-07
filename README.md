# doctrine-odm-enum-type-bundle

Add custom enum mapping types for your MongoDB documents in Symfony. Inspired by [doctrine-enum-type](https://github.com/acelaya/doctrine-enum-type) and based on [php-enum](https://github.com/myclabs/php-enum).

`composer require php-arsenal/doctrine-odm-enum-type-bundle`

[![Release](https://img.shields.io/github/v/release/php-arsenal/doctrine-odm-enum-type-bundle)](https://github.com/php-arsenal/doctrine-odm-enum-type-bundle/releases)
[![CI](https://img.shields.io/github/workflow/status/php-arsenal/doctrine-odm-enum-type-bundle/CI)](https://github.com/php-arsenal/doctrine-odm-enum-type-bundle/actions/workflows/ci.yml)
[![Packagist](https://img.shields.io/packagist/dt/php-arsenal/doctrine-odm-enum-type-bundle)](https://packagist.org/packages/php-arsenal/doctrine-odm-enum-type-bundle)

# How it works?

`Enum` classes that extend `MyCLabs\Enum\Enum` are automatically added as valid Doctrine types.

```php
<?php

namespace YourNamespace\Enum;

use MyCLabs\Enum\Enum;

final class ActionEnum extends Enum
{
    private const CREATE = 'create';
    private const READ = 'read';
    private const UPDATE = 'update';
    private const DELETE = 'delete';
}
```

You can set the type as `Enum` class. Upon saving or retrieving from the database it will be converted to and back the `Enum` class.

```php

<?php

namespace YourNamespace\Entity;

use YourNamespace\Enum\ActionEnum;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ORM\Document()
 */
class User
{
    /**
     * @ODM\Field(type=ActionEnum::class, name="action")
     */
    protected $action;
    
    public function __construct() {
        $this->action = ActionEnum::CREATE();
    }

    public function getAction(): ActionEnum
    {
        return $this->action;
    }

    public function setAction(ActionEnum $action): void
    {
        $this->action = $action;
    }
}
```
