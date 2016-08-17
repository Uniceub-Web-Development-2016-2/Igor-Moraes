<?php

/**
 * Class Request
 * Método de requisição: [MÉTODO] [PROTOCOLO]://[IP-SERVIDOR]/[RESOURCE]?[PARAMS]
 * Métodos: POST, GET, PUT, DELETE
 * Protocolo: HTTP, HTTPS
 * IP-SERVIDOR: Raw Ip (177.782.33) ou Máscara de domínio (www.google.com)
 * Recursos: Entidades - são variáveis e dependem da aplicação.
 * Parâmetros: Relacionados aos recursos
 *
 * O dispositivo cria as requests e o servidor executa
 */
class Request
{

    private $method;
    private $protocol;
    private $ip;
    private $resource;
    private $params;

    /**
     * Request constructor.
     * @param string $method
     * @param string $protocol
     * @param string $ip
     * @param string $resource
     * @param array $params
     */
    public function __construct($method, $protocol, $ip, $resource, $params) {
        $this->setMethod($method);
        $this->setProtocol($protocol);
        $this->setIP($ip);
        $this->setResource($resource);
        $this->setParams($params);
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getProtocol() {
        return $this->protocol;
    }

    /**
     * @param $protocol
     */
    public function setProtocol($protocol) {
        $this->protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getIP() {
        return $this->ip;
    }

    /**
     * @param $ip
     */
    public function setIP($ip) {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * @param $resource
     */
    public function setResource($resource) {
        $this->resource = $resource;
    }

    /**
     * @return array String
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @param $params
     */
    public function setParams($params) {
        $this->params = $params;
    }

    /**
     * Return String of the request
     * @return string
     */
    public function toString() {
        $request = $this->protocol . "://" . $this->ip . "/" . $this->resource . "?";
        foreach ($this->params as $param => $paramValue) {
            $request .= $param . "=" . $paramValue . "&";
        }
        //Removing last character "&" of the string and retrieving it
        return substr($request, 0, -1);
    }

}