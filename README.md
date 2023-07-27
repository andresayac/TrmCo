# TrmCo

Consulta el webservice de la Superintendencia Financiera de Colombia para obtener la tasa de cambio representativa del mercado (TRM) en una fecha específica.

## Instalación

Para instalar este paquete, puedes usar Composer:

```sh
composer require andresaya/trmco
```


## Ejemplo de Uso
```php
<?php
require 'vendor/autoload.php';

use AndresAya\TrmCo\TrmCo;

$trmco = new TrmCo();

// get current TRM
$response = $trmco->query()->get();

// get a date based TRM
$response = $trmco->query('2023-01-01')->get();

// get current and convert to USD
$response = $trmco->query()->copToUsd(15000);

// get current and convert to COP
$response = $trmco->query()->usdToCop(3);

// get a date based TRM and convert to USD
$response = $trmco->query('2023-01-01')->copToUsd(15000);

// get a date based TRM and convert to COP
$response = $trmco->query('2023-01-01')->usdToCop(3);

print_r($response);
```

- El método `$trmco->query()` retorna una objeto.
- El parámetro `fecha` es opcional y debe estár en formato `YYYY-MM-DD`.
- Si el parámetro `fecha` no se especifica, se usará por defecto la fecha actual.
- El resultado devuelto es un objeto con la siguiente estructura:


El resultado devuelto es un objeto con la siguiente estructura:

```php

stdClass Object
(
    [id] => 1530351
    [unit] => COP
    [validityFrom] => 2023-07-22T00:00:00-05:00
    [validityTo] => 2023-07-24T00:00:00-05:00
    [value] => 3971.38
    [success] => 1
)
```

## Nota

>El servicio No retorna datos para las fechas anteriores al año 2013.

Para mas informacion pueden consultar la [documentación Oficial](https://www.superfinanciera.gov.co/jsp/loader.jsf?lServicio=Publicaciones&lTipo=publicaciones&lFuncion=loadContenidoPublicacion&id=60819) del servicio web

## Contribución
Si deseas contribuir a este proyecto, no dudes en hacerlo. Cualquier tipo de mejora, corrección de errores o nuevas características son bienvenidas.

## Licencia
Este proyecto está licenciado bajo la [MIT](LICENSE).

