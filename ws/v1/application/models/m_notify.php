<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_notify extends CI_Model {
      
    public function send($push) {
        ini_set('display_errors','1');
        //return false;
       // print_r($push);
        $user_id = $push['to_user_id'];
        $all_device_token = $this->get_all_device_token($user_id);
        $android = '0';
        foreach ($all_device_token as $key => $device_token) {
            
            if ($device_token['device_type'] == 'android') {
                if ($android == '0') {
                    $this->load->library('gcm');
                    $this->gcm->setMessage($push['message']);
                    $this->gcm->setData($push);
                    $this->gcm->setTtl(false);
                    $this->gcm->setGroup(false);
                }
                $this->gcm->addRecepient($device_token['device_token']);
                $android = '1';
            } else if ($device_token['device_type'] == 'ios') {
                
                $this->load->library('apn');
                $this->apn->payloadMethod = 'enhance';
                $this->apn->connectToPush();
                $this->apn->setData($push);
                
                $send_result = $this->apn->sendMessage($device_token['device_token'], $push['message'], /* badge */ 0, /* sound */ 'default');
//                echo '<pre>';
//                if ($send_result)
//                    echo 'sent success.';
//                else
//                    print_r($this->apn->error);
                $this->apn->disconnectPush();
            }
        }
        if ($android == '1') {
            if($this->gcm->send()){
                $this->gcm->clearRecepients();
            }
             $this->gcm->clearRecepients();

//            echo '<pre>';
//            print_r($this->gcm->status);
//            print_r($this->gcm->messagesStatuses);
        }
    }

    public function get_all_device_token($user_id) {
        return $this->db->where('user_id', $user_id)
                        ->where('status', '1')
                        ->get('device_token')->result_array();
    }
    
//    public function get_all_app_user(){
//        $all_app_user = $this->db->select('user_id')->where('status', '1')
//                        ->get('user')->result_array();
//        return $all_app_user;
//    }

}
