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
	private $serverAddress;
	private $clientAddress;
	private $path;
	private $queryString;
	private $body;


	public function __construct($method, $protocol, $serverAddress, $clientAddress, $path, $queryString, $body)
	{
		$this->method = $method;
		$this->protocol = $protocol;
		$this->serverAddress = $serverAddress;
		$this->clientAddress = $clientAddress;
		$this->path = $path;
		$this->queryString = $queryString;
		$this->body = $body;
	}

}
