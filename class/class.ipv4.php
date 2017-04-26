<?php
/* 
 * Author : Pijush Gupta<pijush@live.com>
 */
class Ipv4 {
    
    private $ip_address = array();
    private $subnet_mask = array();
    private $cidr_value;
    private $class_value;
    
    function __construct(){ 
    }
    
//    setting values without magic methods :(
    
    public function set_ip_address($ip_address=null){
        if($ip_address!=null){
            if(is_array($ip_address)){
                $this->ip_address = $ip_address;
            }else{
                $temp_ip = explode(".", $ip_address);
                $this->set_ip_address($temp_ip);
            }
        }
    }
      
    public function set_subnet_mask($subnet_mask=null){
        if($subnet_mask!=null){
            if(is_array($subnet_mask)){
                $this->subnet_mask = $subnet_mask;
                $this->cidr_value=$this->subnet_to_cidr();
            }else{
                $temp_subnet = explode(".",$subnet_mask);
                $this->set_subnet_mask($temp_subnet);
            }
        }
    }
    
    public function set_cidr_value($cidr_value=null){
        if($cidr_value!=null){
            $this->cidr_value = $cidr_value;
            $this->subnet_mask = $this->cird_to_subnet();
        }
    }
     
// end 
      
// getting values
    
    public function get_ip_address(){
        if(!empty($this->ip_address)){
            return $this->ip_address;
        }
    }
    
    public function get_subnet_mask(){
        if(!empty($this->subnet_mask)){
            return $this->subnet_mask;
        }
    }
    
    public function get_cider_value(){
        if(isset($this->cidr_value)){
            return $this->cidr_value;
        }
    }
    
    public function get_ip_class_value(){
        if(isset($this->class_value)){
            return $this->class_value;
        }else{
             $this->set_ip_class_value();
        }
    }
    
    public function get_interesting_octet(){
        
        if(!empty($this->subnet_mask)){
            return $this->subnet_to_interesting_octet();
        }
        
    } 
   
    public function get_valid_hosts(){
        return $this->hosts() - 2;
    }
    
//end
    
// 
    private function hosts(){
        $count = $this->host_bits();
       return pow(2,$count);
    }
    
    private function host_bits(){
        return (32-$this->cidr_value);
    }
    
    private function on_bits($data=null){// This is not the proper way to calculate on bits , but this probably the fastest way to do so! 
        if($data!=null){
         $OnBit = 0;
            $binary_array = array();
            for($i=0;$i < count($data);$i++){
                if($data[$i]==128){
                    $binary_array[$i] = 1;
                }elseif($data[$i]==192){
                    $binary_array[$i] = 2;
                }elseif($data[$i]==224){
                    $binary_array[$i] = 3;
                }elseif($data[$i]==240){
                    $binary_array[$i] = 4;
                }elseif($data[$i]==248){
                    $binary_array[$i] = 5;
                }elseif($data[$i]==252){
                    $binary_array[$i] = 6;
                }elseif($data[$i]==254){
                    $binary_array[$i] = 7;
                }elseif($data[$i]==255){
                    $binary_array[$i] = 8;
                }else{
                    $binary_array[$i] = 0;
                }
                $OnBit += $binary_array[$i];   
            }
            return $OnBit;    
        }
    }
    
    private function on_bits_subnet($data=null){
        if($data == 1){
            return 128;
        }elseif($data == 2){
            return 192;
        }elseif($data == 3){
            return 224;
        }elseif($data == 4){
            return 240;
        }elseif($data == 5){
            return 248;
        }elseif($data == 6){
            return 252;
        }elseif($data == 7){
            return 254;
        }elseif($data == 8){
            return 255;
        }else{
            return 0;
        } 
    }
    
    private function subnet_to_cidr(){
        return $this->on_bits($this->subnet_mask);
    }
    
    private function cird_to_subnet(){   
        $temp_cidr = $this->cidr_value;
        if($temp_cidr<= 8){
            $mask = $this->on_bits_subnet($temp_cidr);
            return array($mask,0,0,0);
        }elseif($temp_cidr>8 && $temp_cidr<= 16){
            $mask = $this->on_bits_subnet($temp_cidr-8);
            return array(255,$mask,0,0);
        }elseif($temp_cidr>16 && $temp_cidr<=24){
            $mask = $this->on_bits_subnet($temp_cidr-16);
            return array(255,255,$mask,0);
        }elseif($temp_cidr>24 && $temp_cidr<=30){
            $mask = $this->on_bits_subnet($temp_cidr-24);
            return array(255,255,255,$mask);
        }
    }
    
    private function subnet_to_interesting_octet(){
        $count=0;
        foreach($this->subnet_mask as $subnet_octet){
           $count++;
            if($subnet_octet!=255){
                return $count;
            }
        }
    }
    
    private function set_ip_class_value(){
        if(!empty($this->ip_address)){
            
            if($this->ip_address[0]<=126){
               $this->class_value = "A";
               $this->get_ip_class_value();
            }
            if(($this->ip_address[0]>=128) && ($this->ip_address[0]<=191)){
                $this->class_value = "B";
                $this->get_ip_class_value();
            }
            if(($this->ip_address[0]>=192) && ($this->ip_address[0]<=223)){
                $this->class_value = "C";
                $this->get_ip_class_value();
            }
            if(($this->ip_address[0]>=224) && ($this->ip_address[0]<=239)){
                $this->class_value = "D";
                $this->get_ip_class_value();
            }
            if(($this->ip_address[0]>=240) && ($this->ip_address[0]<=256)){
                $this->class_value = "E";
                $this->get_ip_class_value();
            }
        }  
    }
}