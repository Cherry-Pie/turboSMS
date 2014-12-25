<?php

namespace Yaro\Turbo;

use Illuminate\Support\Facades\Config;
use Yaro\Turbo\TurboSmsException;


class Turbo
{

    private $client;
    
    public function __construct()
    {
        $this->client = new \SoapClient('http://turbosms.in.ua/api/wsdl.html');
    } // end __construct

    public function auth()
    {
        return $this->doAuth();
    } // end auth
    
    public function getCredits()
    {
        $this->doAuth();
        
        return $this->client->GetCreditBalance()->GetCreditBalanceResult;
    } // end getCredits
    
    public function sms($phone, $message, $sender = false)
    {
        $this->doAuth();
        
        $sms = Array ( 
            'sender'      => $this->getSenderName($sender), 
            'destination' => $this->getValidatedPhone($phone), 
            'text'        => $message 
        ); 
        
        $status = $this->client->SendSMS($sms)->SendSMSResult;
        if (!is_array($status->ResultArray)) {
            throw new TurboSmsException('TurboSMS: '. $status->ResultArray);
        }
        
        $ids = $status->ResultArray;
        $result = array_shift($ids);
        
        return array($res, $ids);
    } // end sms
    
    public function getStatus($idMessage)
    {
        $this->doAuth();
        
        $status = $this->client->GetMessageStatus(array(
            'MessageId' => $idMessage
        )); 
        
        return $status->GetMessageStatusResult;
    } // end getStatus
    
    public function getPendingMessages()
    {
        $this->doAuth();
        
        $result = $this->client->GetNewMessages();
        
        $res = array();
        if (isset($result->GetNewMessagesResult->ResultArray)) {
            $res = $result->GetNewMessagesResult->ResultArray;
        }
        
        return $res;
    } // end getPendingMessages
    
    private function getValidatedPhone($phone)
    {
        $phone = trim($phone);
        if (!preg_match('~^\+~', $phone)) {
            throw new TurboSmsException('TurboSMS: provided phone invalid');
        }
        
        return $phone;
    } // end getValidatedPhone
    
    private function getSenderName($sender)
    {
        if (!$sender) {
            $sender = Config::get('turbo::sender');
        }
        
        if (!$sender) {
            throw new TurboSmsException('TurboSMS: sender name is required');
        }
        
        return mb_substr($sender, 0, 11);
    } // end getSenderName

    private function doAuth()
    {
        $login = Config::get('turbo::login');
        if (!$login) {
            throw new TurboSmsException('TurboSMS: login is required');
        }
        
        $password = Config::get('turbo::password');
        if (!$password) {
            throw new TurboSmsException('TurboSMS: password is required');
        }
        
        $credentials = Array ( 
            'login'    => $login, 
            'password' => $password
        ); 

        return $this->client->Auth($credentials); 
    } // end doAuth
}

