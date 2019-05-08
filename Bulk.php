<?php


namespace buibr\HLR;

use buibr\HLR\HlrApi;
use buibr\HLR\HlrException;
use buibr\HLR\HlrObject;
use buibr\HLR\objects\BulkList;
use buibr\HLR\objects\BulkListObject;
use buibr\HLR\objects\BulkStatusObject;
use buibr\HLR\objects\BulkSubmitObject;

class Bulk {

    /**
     *  Api configuration for hlrlookup.com
     */
    protected $_api;

    /**
     * 
     */
    protected $_numbers;

    /**
     *  GuzzleHttp object to here after request.
     */
    protected $_request = [];

    /**
     * 
     */
    protected $_response = [];

    /**
     * 
     */
    public function __construct( HlrApi $config = null ) {

        if(empty($config) || !($config instanceof HlrApi)){
            throw new HlrException("Invalid instantiation. Missing api config object!!!");
        }

        $this->_api = $config;

        $this->batchName = "batch_" . time();
    }

    /**
     * 
     */
    public function setBatchId( $id = null){
        $this->batchId = $id;
    }

    /**
     * Make the request.
     * @param boolean $start -- Whether to start imediately process or not. Default true
     * @param array $numbers -- List of numbers to be checked.
     */
    public function submit( bool $start, array $numbers = [] ) : BulkSubmitObject{
        
        if(empty($this->_api)) {
            throw new HlrException("Api configurations invalid.");
        }

        if(empty($numbers)) {
            throw new HlrException("Invalid number to check");
        }

        //  implode numbers
        $this->_numbers     = implode(',',$numbers);
        $start              = $start === false ? '' : "&start=yes";
        

        //  guzzle 
        $client             = new \GuzzleHttp\Client(['base_uri'=>'https://www.hlrlookup.com/api/',]);
        
        //  request.
        $this->_request     = $client->request('GET', 'bulk/', [
            'query'=> $this->_api->toArray(),
            'body'=> "batchname={$this->batchName}&data={$this->_numbers}{$start}"
        ]);

        //  
        return new BulkSubmitObject( (string)$this->_request->getBody() , $numbers);
    }

    /**
     * Check if the response of submit is ok.
     */
    public function isSubmited() {
        if( empty($this->_response['submit']) || !($this->_response['submit'] instanceof \stdClass)){
            return false;
        }

        if(!isset($this->_response['submit']->status)){
            return false;
        }

        if($this->_response['submit']->status !== 'OK'){
            return false;
        }

        $this->batchId = $this->_response['submit']->batchid;

        return $this->_request['submit']->getStatusCode() === 200;
    }

    /**
     * Return the status of bulk batch id.
     * @param BulkSubmitObject $batch
     * @return BulkStatusObject
     */
    public function status( BulkSubmitObject $batch ) : BulkStatusObject{

        if( empty( $batch->getBatchId() ) ) {
            throw new HlrException("Batch is not created.");
        }

        //  guzzle 
        $client             = new \GuzzleHttp\Client(['base_uri'=>'https://www.hlrlookup.com/api/',]);
        
        //  request.
        $this->_request     = $client->request('GET', "status/{$batch->getBatchId()}", [
            'query'=> $this->_api->toArray(),
        ]);

        //  response
        return new BulkStatusObject((string)$this->_request->getBody());
        
    }

    /**
     * Response
     * @param BulkSubmitObject $batch
     */
    public function download( BulkSubmitObject $batch ) {

        if( empty( $batch->getBatchId() ) ) {
            throw new HlrException("Batch is not created.");
        }

        //  guzzle 
        $client             = new \GuzzleHttp\Client(['base_uri'=>'https://www.hlrlookup.com/api/',]);
        
        //  request.
        $this->_request     = $client->request('GET', "download/{$batch->getBatchId()}", [
            'query'=> $this->_api->toArray(),
        ]);

        //  response
        return new BulkListObject( (string)$this->_request->getBody() );
    }



}