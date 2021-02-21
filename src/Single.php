<?php


namespace buibr\HLR;

use buibr\HLR\Entity\SingleObject;


class Single
{
    
    /**
     *  Api configuration for hlrlookup.com
     */
    protected $_api;
    
    /**
     *  GuzzleHttp object to here after request.
     */
    protected $_request;
    
    /**
     * @var
     */
    protected $_response;
    
    /**
     * Single constructor.
     *
     * @param \buibr\HLR\HlrApi|null $api
     * @param null                   $number
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \buibr\HLR\Exceptions\HlrException
     */
    public function __construct(HlrApi $api, $number = NULL)
    {
        $api->validate();
        
        $this->_api = $api;
        
        if ($number) {
            return $this->check($number);
        }
    }
    
    /**
     * @param null $number
     *
     * @return \buibr\HLR\Entity\SingleObject
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \buibr\HLR\Exceptions\HlrException
     */
    public function check($number = NULL)
    {
        
        if (empty($number)) {
            throw new HlrException("Invalid number to check");
        }
        
        //  guzzle 
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://www.hlrlookup.com/api/',]);
        
        //  request.
        $this->_request = $client->request('GET', "hlr/?{$this->_api}&msisdn={$number}");
        
        //  response
        $this->_response = new SingleObject((string) $this->_request->getBody());
        
        //  
        return $this->_response;
    }
    
    /**
     * @return bool
     */
    public function isOk()
    {
        return $this->isSuccess() && $this->_response->isVerified();
    }
    
    /**
     *  Check if the request to the host is ok and has response 200
     */
    public function isSuccess()
    {
        return $this->_request->getStatusCode() === 200;
    }
    
}