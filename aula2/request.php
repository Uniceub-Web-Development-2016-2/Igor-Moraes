<?php

class Request
{

    private $protocol;
    private $ip;
    private $resource;
    private $params;
    private $method;

    /**
     * Request constructor.
     * @param string $method
     * @param string $protocol
     * @param string $ip
     * @param string $resource
     * @param array $params
     */
    public function __construct($method, $protocol, $ip, $resource, $params) {
        $this->method = $method;
        $this->protocol = $protocol;
        $this->ip = $ip;
        $this->resource = $resource;
        $this->params = $params;
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
     * @return array
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
     * @return string of the request
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