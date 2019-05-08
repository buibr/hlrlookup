<?php


namespace buibr\HLR;


abstract class HlrBase {
    
    /**
     *  Mobile Country Codes (MCC) and Mobile Network Codes (MNC)
     */
    abstract public function getMccmcn();

    /**
     *  Name of the operator.
     */
    abstract public function getNetwork();

    /**
     *  Country of origin.
     */
    abstract public function getCountry();

    /**
     * Timezone 
     */
    abstract public function getTimezone() : string;

    /**
     * Phone type home/fax/mobile
     */
    abstract public function getType() : string ;

    /**
     * Get raw body from response (not json)
     */
    abstract public function getRaw() : string;

    /**
     * Get the error from provider response.
     */
    abstract public function getError();

    /**
     * Error code from provider response.
     */
    abstract public function getErrorCode();

}
