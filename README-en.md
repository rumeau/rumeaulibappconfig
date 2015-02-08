## RumeauLibAppConfig ##

This module adds an extra layer of configuration through a Doctrine2 Entity.

### Install ###

#### Composer ####

```composer require rumeau/rumeaulib-appconfig```

#### Zend Framework ####

Enable the module in `application.config.php`

```php
<?php

return array(
    'modules' => array(
        // ... All my modules
        
        'RumeauLibAppConfig',
    ),
    
    // ...
```

#### DataBase ####

The RumeauLibAppConfig module works with a DB and Doctrine2, to use the DB table
a Doctrine2 entity class is included (`RumeauLibAppConfig\Entity\AppConfig`) which can
be imported through CLI:
 
`php vendor/doctrine/doctrine-module/bin/doctrine-module.php orm:schema-tool:update --dump-sql` Test the update

`php vendor/doctrine/doctrine-module/bin/doctrine-module.php orm:schema-tool:update --force` To apply changes

This entity create a the configuration table within the database where all configuration can be stored.

You can use your own entity class overriding the module configuration.

#### Configuration ####

Copy the file `config/rumeaulibappconfig.global.php.dist` tou your application config fodler (usually `config/autoload/`) and rename it to `config/rumeaulibappconfig.global.php`

|Option|Description|
|-------------------|-------------------------------------------------------------------------------|
|config_entity_class|Class name of the configuration entity to use|
|object_manager|Entity manager to persist changes|
|cache|Cache object configuration (Zend\Cache)
|forms|Forms (Fieldsets) for configuration options, you can add as much fieldsets as you want in order to provide a UI to manage configurations (ie: `array( 'global_settings' => 'MyApp\Form\GlobalSettingsFieldset')`)|

### Info ###

* Web: http://www.jprumeau.com/2014/10/15/rumeaulibappconfig-configuracion-de-aplicaciones
* Author: [Jean Rumeau](http://www.jprumeau.com/) - <rumeau@gmail.com> 
