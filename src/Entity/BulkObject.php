<?php

namespace buibr\HLR\Entity;

use buibr\HLR\HlrBase;
use buibr\HLR\Exceptions\HlrException;

class BulkObject extends HlrBase
{
    /**
     * Raw data from response.
     */
    public $_raw;
    
    /**
     *
     */
    public function __construct($data)
    {
        try {
            $this->_raw = $data;
        } catch (\Exception $e) {
            throw new HlrException($e->getMessage(), $e->getCode());
        } catch (\Error $e) {
            throw new HlrException($e->getMessage(), $e->getCode());
        }
    }
    
    /**
     *  Check if has body and positive response.
     */
    public function isVerified()
    {
        
        if (empty($this->_raw)) {
            return FALSE;
        }
        
        if (!empty($this->_raw['Valid Number'])) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     *  Mobile Country Codes (MCC) and Mobile Network Codes (MNC)
     */
    public function getMccmcn()
    {
        return NULL;
    }
    
    /**
     *  Name of the operator.
     */
    public function getNetwork()
    {
        return empty($this->_raw['Current Network']) ? $this->_raw['Original Network'] : $this->_raw['Current Network'];
    }
    
    /**
     *  Country of origin.
     */
    public function getCountry()
    {
        return @$this->_raw['Current Country'];
    }
    
    /**
     *  Country of origin.
     */
    public function getCountryCode()
    {
        return NULL;
    }
    
    /**
     * Timezone
     */
    public function getTimezone(): string
    {
        return '';
    }
    
    /**
     * Phone type home/fax/mobile
     */
    public function getType(): string
    {
        return $this->_raw['Type'];
    }
    
    /**
     * Get raw body from response (not json)
     * @return string
     */
    public function getRaw(): string
    {
        return json_encode($this->_raw);
    }
    
    /**
     *  Get error text
     * @return mixed|string|int
     */
    public function getError()
    {
        return $this->_raw['Error Text'];
    }
    
    /**
     *  Get error code
     * @return string
     */
    public function getErrorCode()
    {
        return $this->_raw['Error Code'];
    }
    
    /**
     * Check if this number is actualy in roaming.
     * @return bool
     */
    public function isRoaming(): boolean
    {
        return empty($this->_raw['Roaming Country']) ? FALSE : TRUE;
    }
    
}
