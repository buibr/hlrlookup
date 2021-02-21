<?php

namespace buibr\HLR\Entity;

use buibr\csvhelper\CsvParser;
use buibr\HLR\Exceptions\HlrException;

class BulkListObject
{
    /**
     * @var string
     */
    public $_raw;
    
    /**
     * @var
     */
    public $_data;
    
    public function __construct($data)
    {
        try {
            // step 1
            $this->_raw = (string) $data;
            
            // step 2
            $this->parser();
        } catch (\Exception $e) {
            throw new HlrException($e->getMessage(), $e->getCode());
        } catch (\Error $e) {
            throw new HlrException($e->getMessage(), $e->getCode());
        }
    }
    
    /**
     * @return $this
     * @throws \ErrorException
     * @throws \buibr\HLR\Exceptions\HlrException
     */
    public function parser()
    {
        $csv = new CsvParser;
        $csv->fromData($this->_raw);
        
        foreach ($csv->toArray() as $id => $obj) {
            if (empty($obj)) continue;
            $this->_data[$id] = new BulkObject($obj);
        }
        
        return $this;
    }
    
    /**
     * Return the data.
     */
    public function getData()
    {
        return $this->_data;
    }
    
}