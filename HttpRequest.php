<?php 

class HttpRequest
{
    private $_httpRequest;

    public function __construct($httpRequest)
    {
        $this->_httpRequest = $httpRequest;
    }

    public function setUrl($url)
    {
        $this->_httpRequest->setUrl($url);
    }
    
    public function send(array $data = array())
    {
        $this->_httpRequest->addQueryData($data);
        try {
            $this->_httpRequest->send();
            if ($this->_httpRequest->getResponseCode() == 200) {
                return json_decode($this->_httpRequest->getResponseBody(), true);
            }
            return array();
        } catch (\HttpException $exception) {
            return false;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}


