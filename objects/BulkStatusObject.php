<?php

namespace buibr\HLR\objects;

use buibr\HLR\HlrApi;
use buibr\HLR\HlrException;

class BulkStatusObject 
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

            if(!isset($this->_raw->status)){
                throw new \ErrorException("Unsuported data format.");
            }
        }
        catch( \Exception $e ){
            throw new HlrException($e->getMessage(), $e->getCode());
        }
        catch( \Error $e ){
            throw new HlrException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *  Batch id.
     */
    public function getBatchId() {
        return $this->_raw->batchid;
    }

    /**
     *  Get the staus of this bulk.
     */
    public function getStatus(){
        return $this->_raw->status;
    }

    /**
     * get total number of records processed/to be porcessed
     */
    public function getTotalRecords(){
        return $this->_raw->total_records;
    }

    /**
     * Get Remaining Records
     */
    public function getRecordsRemaining(){
        return $this->_raw->records_remaining;
    }

    /**
     * return if the batch is processed or not..
     */
    public function isFinished() {
        return strtolower($this->_raw->status) === 'complete';
    }
}