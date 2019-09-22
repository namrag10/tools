<?php

namespace RGarman\Container;

use Exception;

class Container {
    
    private $Container = [];

    public function get($key){
        try{
            if($key == "*"){
                return array_keys($this->Container);
            }elseif($this->has($key)){
                return $this->Container[$key];
            }
            throw new Exception("\n'{$key}' does not exist!\n");
        }catch(Exception $e){
            echo $e->getMessage;
        }
    }

    public function has($key){
        return isset($this->Container[$key]);
    }

    public function set($key, $value){
        try{
            if($key == "*"){
                throw new Exception("\nCannot write over special character! '*'\n");
            }
            $this->Container[$key] = $value;
            return $this;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function dumpRaw(){
        return $this->Container;
    }
}