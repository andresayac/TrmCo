<?php

namespace AndresAya\TrmCo;

use SoapClient, SoapFault;
use InvalidArgumentException, RuntimeException;
use DateTime;

/**
 * Clase para consultar la Tasa Representativa del Mercado (TRM) en Colombia.
 */
class TrmCo
{
    private $wsdl_url;
    private $response;
    private $value;
    private $date;

    public function __construct()
    {
        $this->wsdl_url = 'https://www.superfinanciera.gov.co/SuperfinancieraWebServiceTRM/TCRMServicesWebService/TCRMServicesWebService?WSDL';
    }

    /**
     * Consulta la TRM para una fecha específica.
     *
     * @param string $date La fecha para la que se desea consultar la TRM, en formato YYYY-MM-DD.
     * @return mixed La respuesta del servicio web.
     * @throws InvalidArgumentException Si la fecha proporcionada no es válida.
     * @throws SoapFault Si ocurre un error al hacer la solicitud al servicio web.
     */
    public function query($date = null)
    {

        if ($date == null) {
            $date = date('Y-m-d');
        }
        // Validar el formato de la fecha
        if (!$this->validateDate($date)) {
            throw new InvalidArgumentException('La fecha proporcionada no es válida. Debe estar en formato YYYY-MM-DD y no ser anterior a 2013.');
        }

        $this->date = $date;

        try {
            $options = array(
                'location' => $this->wsdl_url,
                'soap_version' => 'SOAP_1_2',
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ])
            );

            $client = new SoapClient($this->wsdl_url, $options);
            $response =  $client->queryTCRM(["tcrmQueryAssociatedDate" => $date]);

            if (!isset($response->return)) {
                throw new RuntimeException('No se pudo obtener la TRM para la fecha ' . $date);
            }

            $this->response =  $response->return;
            $this->value =  $response->return->value;

            return $this;
        } catch (SoapFault $e) {
            throw $e;
        }
    }

    public function get()
    {
        if (!isset($this->response))
            $this->query();

        return $this->response;
    }

    public function copToUsd($cop)
    {
        if (!is_numeric($cop)) {
            throw new InvalidArgumentException('La entrada debe ser un número');
        }

        return [
            'usd' => $cop / $this->value,
            'cop' => $cop,
            'trm' => $this->value,
            'date' => $this->date,
        ];
    }

    public function usdToCop($usd)
    {
        if (!is_numeric($usd)) {
            throw new InvalidArgumentException('La entrada debe ser un número');
        }
        
        return [
            'usd' => $usd,
            'cop' => $usd * $this->value,
            'trm' => $this->value,
            'date' => $this->date,
        ];
    }

    /**
     * Valida una fecha.
     *
     * @param string $date La fecha a validar, en formato YYYY-MM-DD.
     * @return bool Verdadero si la fecha es válida y no es anterior a 2013, falso en caso contrario.
     */
    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // Comprobar si la fecha es válida y si es posterior a 2012
        return $d && $d->format($format) === $date && $d->format('Y') >= 2013;
    }
}
