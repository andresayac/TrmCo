# TrmCo

Consulta el webservice de la Superintendencia Financiera de Colombia para obtener la tasa de cambio representativa del mercado (TRM) en una fecha específica.

## Instalación

Para instalar este paquete, puedes usar Composer:

```sh
composer require andresaya/trmco
```


## Ejemplo de Uso
```php
require 'vendor/autoload.php';

use AndresAya\TrmCo\TrmCo;

$trmco = new TrmCo();
$response = $trmco->query('2023-07-22');

print_r($response);
```

- El método `$trmcol->query()` retorna una objeto.
- El parámetro `fecha` es opcional y debe estár en formato `YYYY-MM-DD`.
- Si el parámetro `fecha` no se especifica, se usará por defecto la fecha actual.
- El resultado devuelto es un objeto con la siguiente estructura:


El resultado devuelto es un objeto con la siguiente estructura:

```php
object(stdClass)#2 (1) {
  ["return"]=>
  object(stdClass)#3 (6) {
    ["id"]=>
    int(660701)
    ["unit"]=>
    string(3) "COP"
    ["validityFrom"]=>
    string(25) "2018-03-29T05:00:00.000Z"
    ["validityTo"]=>
    string(25) "2018-04-02T05:00:00.000Z"
    ["value"]=>
    float(2780.47)
    ["success"]=>
    bool(true)
  }
}
```

## Nota

>El servicio No retorna datos para las fechas anteriores al año 2013.

Para mas informacion pueden consultar la [documentación Oficial](https://www.superfinanciera.gov.co/jsp/loader.jsf?lServicio=Publicaciones&lTipo=publicaciones&lFuncion=loadContenidoPublicacion&id=60819) del servicio web

## Contribución
Si deseas contribuir a este proyecto, no dudes en hacerlo. Cualquier tipo de mejora, corrección de errores o nuevas características son bienvenidas.

## Licencia
Este proyecto está licenciado bajo la [MIT](LICENSE).

