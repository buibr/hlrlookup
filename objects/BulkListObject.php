<?php

namespace buibr\HLR\objects;

use buibr\HLR\HlrException;
use buibr\HLR\objects\BulkObject;
use buibr\csvhelper\CsvParser;

class BulkListObject 
{
    /**
     *  Raw data from response.
     */
    public $_raw;

    /**
     *  Data parsed.
     */
    public $_data;

    public function __construct( $data ){
        try
        {
            // step 1
            $this->_raw = (string)$data;

            // step 2
            $this->parser();
        }
        catch( \Exception $e ){
            throw new HlrException($e->getMessage(), $e->getCode());
        }
        catch( \Error $e ){
            throw new HlrException($e->getMessage(), $e->getCode());
        }
    }


    /**
     * 
     */
    public function parser(){

        $csv = new CsvParser;
        $csv->fromString( $this->_raw );

        foreach($csv->toArray() as $id=>$obj){
            if(empty($obj)) continue;
            $this->_data[$id] = new BulkObject( $obj );
        }

        return $this;
    }

}