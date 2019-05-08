<?php

namespace buibr\HLR;

class HlrApi {

    public $apikey;


    public $password;


    /**
     * 
     */
    public function __construct( $data = [] ){
        $this->apikey       = isset($data['apikey']) ? $data['apikey'] : $this->apikey;
        $this->password     = isset($data['password']) ? $data['password'] : $this->password;

        return $this;
    }


    public function validate()
    {
        //  
        if(empty($this->apikey)){
            throw new HlrException("Configuration invalid: Api key is missing");
        }

        //  
        if(empty($this->password)){
            throw new HlrException("Configuration invalid: Password is missing");
        }

        return true;
    }

     /**
     * 
     */
    public function __toString(){
        return "apikey=" . $this->apikey . "&password=".$this->password;
    }

    /**
     * return array of config.
     */
    public function toArray() {
        return (array) $this;
    }

   
}