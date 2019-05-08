<?php


namespace buibr\HLR;

use buibr\HLR\objects\SingleObject;


class Single {

    /**
     *  Api configuration for hlrlookup.com
     */
    protected $_api;


    /**
     *  GuzzleHttp object to here after request.
     */
    protected $_request;

    /**
     * 
     */
    protected $_response;

    /**
     * 
     */
    public function __construct( HlrApi $config = null, $number = null ) {

        if(empty($config) || !($config instanceof HlrApi)){
            throw new HlrException("Invalid instantiation. Missing api config object!!!");
        }

        $this->_api = $config;

        if( empty($number) ) {
            return $this;
        }
            
        return $this->check( $number );
    }

    /**
     * Make the request.
     */
    public function check( $number = null){
        
        if(empty($this->_api)) {
            throw new HlrException("Api configurations invalid.");
        }

        if(empty($number)) {
            throw new HlrException("Invalid number to check");
        }

        //  guzzle 
        $client             = new \GuzzleHttp\Client(['base_uri'=>'https://www.hlrlookup.com/api/',]);
        
        //  request.
        $this->_request     = $client->request('GET', "hlr/?{$this->_api}&msisdn={$number}");

        //  response
        $this->_response    = new SingleObject( (string)$this->_request->getBody() );

        //  
        return $this->_response;
    }

    /**
     *  Check if the request to the host is ok and has response 200
     */
    public function isSuccess(){
        return $this->_request->getStatusCode() === 200;
    }

    /**
     * 
     */
    public function isOk(){
        return $this->isSuccess() && $this->_response->isVerified();
    }

}