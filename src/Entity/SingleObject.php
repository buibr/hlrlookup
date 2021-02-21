<?php

namespace buibr\HLR\Entity;

use buibr\HLR\HlrBase;
use buibr\HLR\Exceptions\HlrException;

class SingleObject extends HlrBase
{
    /**
     * raw data from response.
     */
    public $_raw;
    
    /**
     * SingleObject constructor.
     *
     * @param $data
     *
     * @throws \buibr\HLR\Exceptions\HlrException
     */
    public function __construct($data)
    {
        try {
            $this->_raw = \json_decode((string) $data);
        } catch (\Exception $e) {
            throw new HlrException($e->getMessage(), $e->getCode());
        } catch (\Error $e) {
            throw new HlrException($e->getMessage(), $e->getCode());
        }
    }
    
    /**
     * Check if has body and positive response.
     *
     * @return bool
     */
    public function isVerified()
    {
        
        if (empty($this->_raw) || !($this->_raw instanceof \stdClass)) {
            return FALSE;
        }
        
        if (!isset($this->_raw->issueing_info)) {
            return FALSE;
        }
        
        if (isset($this->_raw->ERR)) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Mobile Country Codes (MCC) and Mobile Network Codes (MNC)
     *
     * @return null
     */
    public function getMccmcn()
    {
        return $this->isVerified() ? $this->_raw->mccmnc : NULL;
    }
    
    /**
     * Name of the operator.
     *
     * @return null
     */
    public function getNetwork()
    {
        return $this->isVerified() ? $this->_raw->issueing_info->network_name : NULL;
    }
    
    /**
     * Country of origin.
     *
     * @return null
     */
    public function getCountry()
    {
        return $this->isVerified() ? $this->_raw->issueing_info->location : NULL;
    }
    
    /**
     * Country of origin.
     *
     * @return null
     */
    public function getCountryCode()
    {
        return $this->isVerified() ? $this->_raw->issueing_info->country_code : NULL;
    }
    
    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->isVerified() ? $this->_raw->issueing_info->timezone : '';
    }
    
    /**
     * Phone type home/fax/mobile
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->isVerified() ? $this->_raw->type : '';
    }
    
    /**
     * Get raw body from response (not json)
     *
     * @return string
     */
    public function getRaw(): string
    {
        return json_encode($this->_raw);
    }
    
    /**
     * Get error text
     *
     * @return string
     */
    public function getError()
    {
        return @trim(isset($this->_raw->ERR) ? $this->_raw->ERR : @$this->_raw->error_text);
    }
    
    /**
     * Get error code
     *
     * @return string
     */
    public function getErrorCode()
    {
        return @trim(isset($this->_raw->ERR) ? $this->_raw->ERR : @$this->_raw->error_code);
    }
    
    /**
     * Check if this number is actualy in roaming.
     *
     * @return bool
     */
    public function isRoaming(): boolean
    {
        return $this->isVerified() ? $this->_raw->is_roaming : false;
    }
    
}
