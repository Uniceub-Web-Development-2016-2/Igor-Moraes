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
    private $server;
    private $remote_ip;
    private $resource;
    private $params;

    /**
     * Request constructor.
     * @param $method
     * @param $protocol
     * @param $server
     * @param $remote_ip
     * @param $resource
     * @param $params
     */
    public function __construct($method, $protocol, $server, $remote_ip, $resource, $params) {
        $this->setMethod($method);
        $this->setProtocol($protocol);
        $this->setServer($server);
        $this->setRemoteIP($remote_ip);
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
        $this->protocol = substr($protocol, 0, -4);
    }

    /**
     * @return string
     */
    public function getServer() {
        return $this->server;
    }

    /**
     * @param $server
     */
    public function setServer($server) {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function getRemoteIP() {
        return $this->remote_ip;
    }

    /**
     * @param $remote_ip
     */
    public function setRemoteIP($remote_ip) {
        $this->remote_ip = $remote_ip;
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
        $this->params = $this->paramsToArray($params);
    }

    /**
     * Return String of the request
     * @return string
     */
    public function toString() {
        $request = $this->protocol . "://" . $this->remote_ip . "/" . $this->resource . "?";
        foreach ($this->params as $param => $paramValue) {
            $request .= $param . "=" . $paramValue . "&";
        }
        //Removing last character "&" of the string and retrieving it
        return substr($request, 0, -1);
    }


    /**
     * @param $params
     * @return mixed
     */
    public function paramsToArray($params) {
        parse_str($params, $paramsArray);
        return $paramsArray;
    }

    /**
     * @return string
     */
//    public function getResourceFromURL($url) {
//        $parsedUrl = parse_url($url);
//        return substr($parsedUrl['path'], 1);
//    }



}