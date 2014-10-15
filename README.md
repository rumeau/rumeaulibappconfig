## RumeauLibAppConfig ##

Este módulo agrega una capa de configuración a traves de una base de 
datos usando Doctrine2 como ORM.

Aún esta en proceso de desarrollo por lo que no esta lista para uso en 
producción pero personalmente ya la he probado y es funcional.

### Instalación ###

#### Composer ####

```composer require rumeau/rumeaulib-appconfig```

Para la version solo usa ```dev-master```

#### Zend Framework ####

Habilita el modulo en ```application.config.php```

```php
<?php

return array(
    'modules' => array(
        // ... Mis Modulos
        
        'RumeauLibAppConfig',
    ),
    
    // ...
```

#### Base de Datos ####

RumeauLibAppConfig funciona con una base de datos y con Doctrine2, 
para esto se incluye el respectivo map ```RumeauLibAppConfig\Entity\AppConfig``` 
el que puede ser importado con:
 
```php vendor/doctrine/doctrine-module/bin/doctrine-module.php orm:schema-tool:update --dump-sql``` Para probar primero

```php vendor/doctrine/doctrine-module/bin/doctrine-module.php orm:schema-tool:update --force``` Para aplicar los cambios

Esta entidad creara la respectiva tabla en su base de datos en 
donde se almacenaran las configuraciones.

Puedes usar tu propia entidad utilizando el archivo de configuracion 
proporcionado para el modulo

#### Configuración ####

Copia el archivo ```config/rumeaulibappconfig.global.php.dist``` a tu 
directorio de configuraciones (generalmente ```config/autoload/```) y 
cambiando su nombre a ```config/rumeaulibappconfig.global.php```

|Claves|Descripcion|
|-------------------|-------------------------------------------------------------------------------|
|config_entity_class|Establece la entidad a usar para guardar la configuracion|
|object_manager|Entity manager para persistir los cambios|
|cache|Configuracion para el cache de la configuracion (Zend\Cache)
|forms|Formularios (Fieldsets) que se agregaran a la configuracion (ie: array( 'global_settings' => 'MyApp\Form\GlobalSettingsFieldset'))|

### Info ###

Web: http://www.jprumeau.com/2014/10/15/rumeaulibappconfig-configuracion-de-aplicaciones
Author: [Jean Rumeau](http://www.jprumeau.com/) - <rumeau@gmail.com> 
