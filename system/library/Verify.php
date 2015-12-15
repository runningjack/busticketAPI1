<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/3/15
 * Time: 7:46 AM
 */

namespace system\library;
use system\library\Hashing\Shahash;
use system\library\Database\DB;
class Verify {

    protected   $key;
    protected   $secret;
    protected   $from;

    protected   $salt = "VPOS";
    protected   $length = 6;

    protected   $owner = "amedora33@hotmail.com";
    protected   $subacct = "RIBS";
    protected   $subacctPwd = "admin2012";
    protected   $sender = "VPOS";





// "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=amedora33@hotmail.com&subacct=RIBS&subacctpwd=admin2012&message=".urlencode($message)."
//&sender=RIBS&sendto=".urlencode($number)."&msgtype=0"; //


    //const API_URI ='http://rest.nexmo.com/sms/json?username=%1$s&password=%2$s&from=%3$s&to=%4$s&text=%5$s';
    const API_URI ='http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=%1$s&subacct=%2$s&subacctpwd=%3$s&message=%4$s&sender=%5$s&sendto=%6$s&msgtype=0';
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';

    public function __construct($key="", $secret="", $from="VirtualPOS", $options = array())
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->from = $from;

        $this->salt = $key . $secret;

        foreach($options as $option => $value){
            if(property_exists($this, $option)){
                $this->$option = $value;
            }
        }
    }

    public function get($id,$params)
    {
        error_log($id);
        foreach(array('number', 'pin') as $param){
            if(!isset($params[$param])){
                throw new \Exception('missing required param: ' . $param, 400);
            }
        }
        //return validation status
        try{
            return $this->checkHash($id,$params);
        }catch (\RuntimeException $e){
            echo $e->getMessage();
        }




    }

    public function post($params,$table="",$pk="")
    {
        //check for valid request
        if(!isset($params['number'])){
            throw new \Exception('missing required param: number', 400);
        }

        $number = $params['number'];

        //generate pin

        $pin = rand(0, pow(10,$this->length)-1);
        $pin = str_pad($pin, $this->length, '0', STR_PAD_LEFT);
        $text = "Your VirtualPOS verification code is ".$pin;

        //send pin
        $this->sendSms($number, $text);

        //get hash
        $hash = $this->getHash($pin, $number,$table,$pk);

        //return hash
        return array('hash' => $hash);
    }

    public function run($method, $request, $params)
    {
        switch($method){
            //verify a pin
            case self::HTTP_GET:
                return $this->get($request, $params);
            //get a new token
            case self::HTTP_POST:
                return $this->post($params);
            default:
                throw new \Exception('invalid request: ' . $method, 400);
        }
    }

    protected function sendSms($to, $text){
        //removes occurrence of "+234" and "234" from the beginning of the string 227e1631-622d-43f0-be87-9ec0bb288d6a
        $pattern = array("/^\+?234/","/^0/");
        $sendto = "0".preg_replace($pattern,"",$to);

        $uri = sprintf(self::API_URI, $this->owner, $this->subacct, $this->subacctPwd, $text, $this->sender,$sendto);
        //print_r($uri);
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        if($result){
            $ret = trim($result);
            $send = explode(":",$ret);
            if ($send[0] == "OK"){
                return true;
            }else{
                //throw new \Exception($send[0], 500);
            }

        }

       /* $result = json_decode($result);
        foreach($result->messages as $message){
            if(isset($message->{'error-text'})){
                throw new \Exception($message->{'error-text'}, 500);
            }
        }*/
    }

    protected function getHash($pin, $number,$table="customers",$pk){

        $hashed = Shahash::make($pin,$options = array("number"=>$number,"key_salt"=>$this->salt));
        if(DB::update($table,array("hashed"=>$hashed,"phone"=>$number,"key_salt"=>$this->salt,"id"=>$pk))){
            return true;
        }else{
            throw new \RuntimeException("Pin generation process error");
        }
        //echo  $myobj->offsetGet("hashed");
        //return $hashed;
    }

    protected function checkHash($hashed,array $params = array()){
        //echo $this->salt."8uiuu";
        if (Shahash::check($params["pin"],$hashed,$options = array("number"=>$params["number"],"pin"=>$params["pin"],"key_salt"=>$this->salt))){
            return true;
        }else{
            return false;
        }

    }
}