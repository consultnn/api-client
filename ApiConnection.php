<?php

namespace consultnn\api;

use consultnn\api\exceptions\ConnectionException;

/**
 * Class ApiConnection
 * @package DGApiClient
 */
class ApiConnection
{

    /* @var \Psr\Log\LoggerInterface */
    private $logger;

    /* @var string $url url to API */
    public $url = 'http://api.directory.docker';

    /* @var string $version api version */
    public $version = 'v1';

    /* @var string $format */
    protected $format = 'json';

    /* @var string $locale */
    public $locale = 'ru_RU';

    /* @var int $timeout in milliseconds */
    public $timeout = 5000;

    public $formatParam = '_format';

    /* @var resource $curl */
    protected $curl;

    /**
     * Throw exception or store it into $lastError variable
     * @var bool $raiseException
     */
    public $raiseException = true;

    /**
     * This variable contains exception class if $raiseException is false.
     * @var \Exception
     */
    protected $lastError;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct($logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * Returns last Exception if $raiseException is false
     * @return \Exception
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * @param string $value
     * @return string
     * @throws ConnectionException
     */
    public function setFormat($value)
    {
        $value = strtolower($value);
        if (in_array($value, array('json', 'jsonp', 'xml'))) {
            return $this->format = $value;
        } else {
            throw new ConnectionException("Unknown format $value");
        }
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $service
     * @param array $params
     * @return array|string
     * @throws ConnectionException
     */
    public function send($service, array $params = array())
    {
        $curl = $this->getCurl();
        curl_setopt(
            $this->curl,
            CURLOPT_URL,
            $this->getRequest($service, $params)
        );
        $data = curl_exec($curl);

        if (curl_errno($curl)) {
            return $this->raiseException(curl_error($curl), curl_errno($curl), null, 'CURL');
        }
        if ($this->getFormat() === 'xml') {
            return $data;
        }

        $response = $this->decodeResponse($data);
        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200) {
            return $this->raiseException($response['message'], $response['status']);
        }

        if (!$response || !isset($response['result'])) {
            return $this->raiseException("Invalid response message");
        }

        $this->lastError = null;
        return $response['result'];
    }

    /**
     * @param string $service
     * @param array $params
     * @return string
     */
    public function getRequest($service, array $params = array())
    {
        $params = array_filter($params);
        $params[$this->formatParam] = $this->format;
        $url = $this->url . '/' . $this->version . '/' . $service . '?' . http_build_query($params);
        if ($this->logger) {
            $this->logger->info($url);
        }
        return $url;
    }

    /**
     * @param string $data
     * @return mixed
     */
    private function decodeResponse($data)
    {
        switch ($this->format) {
            /** @noinspection PhpMissingBreakStatementInspection */
            case 'jsonp':
                $data = preg_replace("/ ^[?\w(]+ | [)]+\s*$ /x", "", $data); //JSONP -> JSON
            case 'json':
                return @json_decode($data, true);
        }
        return $data;
    }

    /**
     * @return resource
     */
    private function getCurl()
    {
        if ($this->curl === null) {
            $this->curl = curl_init();
            curl_setopt_array($this->curl, array(
                CURLOPT_TIMEOUT_MS => $this->timeout,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_USERAGENT => 'PHP ' . __CLASS__,
                CURLOPT_ENCODING => 'gzip, deflate'
            ));
        }
        return $this->curl;
    }

    public function __destruct()
    {
        if ($this->curl !== null) {
            unset($this->curl);
        }
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     * @param string $type
     * @return bool
     * @throws ConnectionException
     */
    protected function raiseException($message = "", $code = 0, \Exception $previous = null, $type = "")
    {
        $exception = new ConnectionException($message, $code, $previous, $type);
        if ($this->logger) {
            $this->logger->error("[$code]: $type $message", array('exception' => $exception));
        }
        if ($this->raiseException) {
            throw $exception;
        } else {
            $this->lastError = $exception;
        }
        return false;
    }
}
