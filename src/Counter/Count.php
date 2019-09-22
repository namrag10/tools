<?php

namespace RGarman\Counter;

class Count {
    private $Counter = 0;
    private $Mode = 1;

    public function __construct($StartVal = 0){
        $this->Counter = $StartVal;
        return $this;
    }

    public function Down(){
        $this->Mode = -1;
        return $this;
    }

    public function Up(){
        $this->Mode = 1;
        return $this;
    }

    public function Reset(){
        $this->Counter = 0;
        return $this;
    }

    public function Next($Amount = 1){
        try{
            if(is_string($Amount)){
                throw new Exception("Amount cannot be string!");
            }
            $this->Counter += $this->Mode;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function get(){
        return $this->Counter;
    }

}