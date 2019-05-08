<?php

namespace buibr\HLR\objects;

use buibr\HLR\HlrApi;
use buibr\HLR\HlrException;

class BulkSubmitObject 
{

    /**
     *  Raw data from response.
     */
    public $_raw;

    /**
     *  
     */
    public function __construct( $data ){
        try
        {
            $this->_raw = \json_decode( (string)$data );
        }
        catch( \Exception $e ){
            throw new HlrException($e->getMessage(), $e->getCode());
        }
        catch( \Error $e ){
            throw new HlrException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * batch id.
     */
    public function getBatchId() {
        return $this->_raw->batchid;
    }

    /**
     * 
     */
    public function getStatus(){
        return $this->_raw->status;
    }

    /**
     * Check if bulk is created.
     */
    public function isCreated(){
        return strtoupper($this->_raw->status) === 'OK' && !empty($this->_raw->batchid);
    }
}