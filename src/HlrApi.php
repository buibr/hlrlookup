<?php

namespace buibr\HLR;

class HlrApi {

    /** @var string */
    public $apikey;
    
    /** @var string */
    public $password;
    
    /**
     *
     */
    public function __construct( $data = [] ){
        $this->apikey       = isset($data['apikey']) ? $data['apikey'] : $this->apikey;
        $this->password     = isset($data['password']) ? $data['password'] : $this->password;

        return $this;
    }
    
    /**
     * @return bool
     * @throws \buibr\HLR\Exceptions\HlrException
     */
    public function validate()
    {
        if(empty($this->apikey)){
            throw new HlrException("Configuration invalid: Api key is missing");
        }
        
        if(empty($this->password)){
            throw new HlrException("Configuration invalid: Password is missing");
        }

        return true;
    }
    
    /**
     * @return string
     */
    public function __toString(){
        return "apikey=" . $this->apikey . "&password=".$this->password;
    }
    
    /**
     * @return array
     */
    public function toArray() {
        return (array) $this;
    }
}