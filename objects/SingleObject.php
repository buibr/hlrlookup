<?php

namespace buibr\HLR\objects;

use buibr\HLR\HlrApi;
use buibr\HLR\HlrBase;
use buibr\HLR\HlrException;

class SingleObject extends HlrBase 
{

    /**
     * raw data from response.
     */
    public $_raw;


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
     *  Check if has body and positive response.
     */
    public function isVerified() {

        if( empty($this->_raw) || !($this->_raw instanceof \stdClass) ){
            return false;
        }

        if(!isset($this->_raw->issueing_info)){
            return false;
        }

        if(isset($this->_raw->ERR)){
            return false;
        }

        return true;
    }

    /**
     *  Mobile Country Codes (MCC) and Mobile Network Codes (MNC)
     */
    public function getMccmcn(){
        return $this->isVerified() ? $this->_raw->mccmnc : null;
    }

    /**
     *  Name of the operator.
     */
    public function getNetwork(){
        return $this->isVerified() ? $this->_raw->issueing_info->network_name : null;
    }

    /**
     *  Country of origin.
     */
    public function getCountry(){
        return $this->isVerified() ? $this->_raw->issueing_info->location : null;
    }

    /**
     *  Country of origin.
     */
    public function getCountryCode(){
        return $this->isVerified() ? $this->_raw->issueing_info->country_code : null;
    }

    /**
     * Timezone 
     */
    public function getTimezone() : string{
        return $this->isVerified() ? $this->_raw->issueing_info->timezone : null;
    }

    /**
     * Phone type home/fax/mobile
     */
    public function getType() : string {
        return $this->isVerified() ? $this->_raw->type : null;
    }

    /**
     * Get raw body from response (not json)
     * @return string
     */
    public function getRaw() : string{
        return json_encode( $this->_raw );
    }

    /**
     *  Get error text
     * @return mixed|string|int
     */
    public function getError() {
        return @trim(isset($this->_raw->ERR) ? $this->_raw->ERR : @$this->_raw->error_text);
    }

    /**
     *  Get error code
     * @return string
     */
    public function getErrorCode() {
        return @trim(isset($this->_raw->ERR) ? $this->_raw->ERR : @$this->_raw->error_code);
    }

    /**
     * Check if this number is actualy in roaming.
     * @return bool
     */
    public function isRoaming() : boolean {
        return $this->isVerified() ? $this->_raw->is_roaming : null;
    }

}
