<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        parent::__construct();
        $this->load->model('m_api');
        $this->load->model('m_notify');
        $this->response = array();
        //$this->output->set_header('Authorization: 272cee7490ddfdf72b9ce9a989efcdd0',true);
        if (isset($_REQUEST) && $_REQUEST) {
            log_message('error', $this->uri->uri_string() . ' /// request ---> ' . json_encode($_REQUEST));
        }
        if (isset($_FILES) && $_FILES) {
            log_message('error', $this->uri->uri_string() . ' /// files ---> ' . json_encode($_FILES));
        }
        $headers = $this->input->request_headers();
        if (isset($headers['Authorization']) && $headers['Authorization']) {
            log_message('error', $this->uri->uri_string() . ' /// header token ---> ' . json_encode($headers['Authorization']));
        }
    }

    public function index() {
        echo 'It\'s working..sdf11111.'. 'date is: ' . date('Y-m-d H:i:s');
        //$this->m_api->send_mail("s", "s", "s");
        $userdata = [];
        // $this->load->view('mail_tmp_new/header');
        // $this->load->view('mail_tmp_new/welcome');
        // $this->load->view('mail_tmp_new/footer');
    }

    public function check_auth() {
        $headers = $this->input->request_headers();

        if (!isset($headers['Authorization']) || $headers['Authorization'] == null) {
            //header token not set
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'User authentication failed. Token not set.',
            );
            echo json_encode(array('response' => $this->response));
            return false;
        } else {
            return $headers['Authorization'];
        }
    }

    public function check_auth_user_id() {
        if (!isset($_POST['user_id']) || $_POST['user_id'] == null) {
            //header token not set
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'User authentication failed. User ID not set.',
            );
            echo json_encode(array('response' => $this->response));
            return false;
        } else {
            return $_POST['user_id'];
        }
    }

    public function validate_token($user_id, $token) {
        $userdata = $this->m_api->get_user_by_user_id_token($user_id, $token);
        if ($userdata) {
            return $userdata;
        } else {
            $this->response[] = array(
                'status' => 'false',
                'screen_code' => '1001',
                'response_msg' => 'User authentication failed. Token mismatch.',
            );
            echo json_encode(array('response' => $this->response));
            return false;
        }
    }

    public function auth() {
        $token = $this->check_auth();
        if ($token) {
            $user_id = $this->check_auth_user_id();
            if ($user_id) {
                $userdata = $this->validate_token($user_id, $token);
                if ($userdata) {
                    return $userdata;
                }
            }
        }
    }

    public function check_parameters($paras = array()) {
        $return = TRUE;
        $not_set = '';
        foreach ($paras as $para) {
            if (!isset($_POST[$para]) || $_POST[$para] == NULL) {
                $return = FALSE;
                if ($not_set != '') {
                    $not_set .= ', ';
                }
                $not_set .= $para;
            }
        }
        if (!$return) {
            log_message('error', 'Parameters not set. ---> ' . $not_set);
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'Please fill required fields'
                    //'response_msg' => 'Parameters not set. ---> ' . $not_set,
            );
            echo json_encode(array('response' => $this->response));
        }
        return $return;
    }

    public function display_system_error() {
        $this->response[] = array(
            'status' => 'false',
            'response_msg' => 'Server error. Something went wrong.',
        );
        echo json_encode(array('response' => $this->response));
        die;
    }

    public function signup() {
       // ini_set('display_errors', 1);
        header('Content-Type: application/json');
        $post = $_POST;

        if(isset($post['is_marketing']) && $post['is_marketing'] == 1) {
            $required = ['first_name', 'last_name', 'email', 'password', 'is_marketing', 'company_name'];
        } else {
            $required = ['first_name', 'last_name', 'email', 'password'];
        }
        

        if ($this->check_parameters($required)) {
            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $this->response[] = array(
                    'status' => 'false',
                    'response_msg' => 'Invalid email address',
                );
                echo json_encode(array('response' => $this->response));
                exit;
            }
            $userdata = $this->m_api->get_user_by_email($post['email']);
            if ($userdata) {
                $post['user_id'] = $userdata['user_id'];
                if ($userdata['status'] == '1') {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Email already exists',
                    );
                    echo json_encode(array('response' => $this->response));
                } else {

                    if (isset($_FILES['profile_pic'])) {
                        $ext = '.' . pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
                        $filename = date('dmyhis') . $post['user_id'] . $ext;
    
                        $config = array(
                            'upload_path' => '../../upload/',
                            'allowed_types' => 'gif|jpg|png|bmp|jpeg',
                            'file_name' => $filename,
                            'max_size' => '20000'
                        );
    
                        $this->upload->initialize($config);
                        $this->upload->do_upload('profile_pic');
                        $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                        $post['profile_pic'] = $filename;
                    }


                    if(isset($post['is_marketing']) && $post['is_marketing'] == 1) {
                        $update_data = ['user_id', 'first_name', 'last_name', 'email', 'password', 'is_marketing', 'company_name'];
                    } else {
                        $update_data = ['user_id', 'first_name', 'last_name', 'email', 'password'];
                    }
                    
                   // $post['status'] = 1;
                    $userdata = $this->m_api->update_user(elements($update_data, $post));

                    if ($userdata['token'] != '') {
                        //$token = $userdata['token'];
                        $token = md5(rand() . rand());
                    } else {
                           $token = md5(rand() . rand());
                    }
                        
                    $this->m_api->update_login_token($post['user_id'], $token);

                    $this->m_api->check_update_device_token($post);

                    $userdata['otp'] = mt_rand(1000, 9999);

                    $update_data['user_id'] = $post['user_id'];
                    $update_data['otp'] = $userdata['otp'];
                    $this->m_api->update_user($update_data);

                    $subject = 'Welcome to '.APP_NAME.'';
                    $msg = $this->load->view('mail_tmp/header', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/welcome', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/footer', $userdata, true);
                    $this->m_api->send_mail($userdata['email'], $subject, $msg);
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Registration successful.',
                        'user_id' => $userdata['user_id'],
                        'token' => $token,
                        'first_name' => $userdata['first_name'],
                        'last_name' => $userdata['last_name'],
                        'email' => $userdata['email'],
                        'is_marketing' => $userdata['is_marketing'],
                        'company_name' => $userdata['company_name'],
                        'screen_code' => '222'
                    );
                    echo json_encode(array('response' => $this->response));
                }
            } else {
                if (isset($_FILES['profile_pic'])) {
                    $ext = '.' . pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
                    $filename = date('dmyhis') . rand() . $ext;

                    $config = array(
                        'upload_path' => '../../upload/',
                        'allowed_types' => 'gif|jpg|png|bmp|jpeg',
                        'file_name' => $filename,
                        'max_size' => '20000'
                    );

                    $this->upload->initialize($config);
                    $this->upload->do_upload('profile_pic');
                    $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                    $post['profile_pic'] = $filename;
                }

                
                if(isset($post['is_marketing']) && $post['is_marketing'] == 1) {
                    $signup_data = ['first_name', 'last_name', 'email', 'password', 'status', 'is_marketing', 'company_name'];
                } else {
                    $signup_data = ['first_name', 'last_name', 'email', 'password', 'status'];
                }
                $post['status'] = 1;
                $userdata = $this->m_api->signup(elements($signup_data, $post));
                if ($userdata) {
                    $post['user_id'] = $userdata['user_id'];
                    $this->m_api->check_update_device_token($post);

                    if ($userdata['token'] != '') {
                        //$token = $userdata['token'];
                        $token = md5(rand() . rand());
                    } else {
                           $token = md5(rand() . rand());
                    }
                        
                    $this->m_api->update_login_token($post['user_id'], $token);

                    $userdata['otp'] = mt_rand(1000, 9999);

                    $update_data['user_id'] = $post['user_id'];
                    $update_data['otp'] = $userdata['otp'];
                    $this->m_api->update_user($update_data);

                    $subject = 'Welcome to '.APP_NAME.'';
                    $msg = $this->load->view('mail_tmp/header', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/welcome', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/footer', $userdata, true);
                    $this->m_api->send_mail($userdata['email'], $subject, $msg);

                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Registration successful.',
                        'user_id' => $userdata['user_id'],
                        'token' => $token,
                        'first_name' => $userdata['first_name'],
                        'last_name' => $userdata['last_name'],
                        'email' => $userdata['email'],
                        'is_marketing' => $userdata['is_marketing'],
                        'company_name' => $userdata['company_name'],
                        'screen_code' => '222'
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'System error. User registration failed.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }

    public function signin() {
        header('Content-Type: application/json');
        $post = $_REQUEST;

        if (isset($post['email']) && $post['email'] != null &&
                isset($post['password']) && $post['password'] != null) {
            $userdata = $this->m_api->signin($post);
            // if ($userdata && $userdata['is_email_verified'] == '0') {

            //     $this->resend_verification_mail($post['email']);
            //     $this->response[] = array(
            //         'status' => 'false',
            //         'response_msg' => 'Your email verification is pending. Kindly verify your email to log in.',
            //         'screen_code' => '333', //verification email
            //     );
            //     echo json_encode(array('response' => $this->response));
            // } else 
            if ($userdata) {
                $post['user_id'] = $userdata['user_id'];
               if ($userdata['token'] != '') {
                   //$token = $userdata['token'];
                   $token = md5(rand() . rand());
               } else {
                   $token = md5(rand() . rand());
               }
                
               $this->m_api->update_login_token($post['user_id'], $token);
                //token is valid
                $this->m_api->check_update_device_token($post);

                $screen_code = $this->m_api->check_profile_complition_and_get_screen_code($post['user_id']);
                if ($userdata['password_updated'] == 0) {
                    //111 display update password screen
                    $screen_code = '111';
                }
                if($userdata['profile_pic']) {
                    $profile_pic = $this->m_api->pic_url($userdata['profile_pic']);
                } else {
                    $profile_pic = '';
                }
                $this->response[] = array(
                    'status' => 'true',
                    'response_msg' => 'Signin successful',
                    'token' => $token,
                    'screen_code' => $screen_code,
                    'user_id' => $userdata['user_id'],
                    'first_name' => $userdata['first_name'],
                    'last_name' => $userdata['last_name'],
                    'email' => $userdata['email'],
                    'is_marketing' => $userdata['is_marketing'],
                    'company_name' => $userdata['company_name'],
                    'profile_pic' => $profile_pic
                );
                // $this->response[] = $this->response;
                echo json_encode(array('response' => $this->response));
            } else {
                //invalid user
                $this->response[] = array(
                    'status' => 'false',
                    'response_msg' => 'Invalid email id or password',
                );
                echo json_encode(array('response' => $this->response));
            }
        } else {
            //enter username and password
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'Please enter email and password',
            );
            echo json_encode(array('response' => $this->response));
        }
    }

     function check_social_id() {
        header('content-type:application/json');
        $post = $_POST;
        $required = ['media_type', 'media_id'];
        if ($this->check_parameters($required)) {
            if (isset($post['profile_pic']) && $post['profile_pic']) {
                $ext1 = '.' . pathinfo($post['profile_pic'], PATHINFO_EXTENSION);
                $ext = explode('?', $ext1);
                $filename = date('dmyhis') . rand(1111, 9999) . strtolower($ext[0]);

                copy(stripslashes($post['profile_pic']), '../../upload/' . $filename);
                $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                $post['profile_pic'] = $filename;
            }
            $userdata = $this->m_api->check_social_id($post);
            if ($userdata) {
                $post['user_id'] = $userdata['user_id'];
//                if ($userdata['token'] != '') {
//                    $token = $userdata['token'];
//                } else {
//                    $token = md5(rand() . rand());
//                }
                $token = md5(rand() . rand());
                $this->m_api->update_login_token($post['user_id'], $token);
                //token is valid
                $this->m_api->check_update_device_token($post);

                $screen_code = $this->m_api->check_profile_complition_and_get_screen_code($post['user_id']);
                if ($userdata['password_updated'] == 0) {
                    //111 display update password screen
                    $screen_code = '111';
                }

                $this->response[] = array(
                    'status' => 'true',
                    'response_msg' => 'Signin successful',
                    'token' => $token,
                    'screen_code' => $screen_code,
                    'user_id' => $userdata['user_id'],
                    'first_name' => $userdata['first_name'],
                    'last_name' => $userdata['last_name'],
                    'email' => $userdata['email'],
                    'phone' => $userdata['phone'],
                    'is_marketing' => $userdata['is_marketing'],
                    'company_name' => $userdata['company_name'],
                );
                echo json_encode(array('response' => $this->response));
            } else {
                $this->response[] = array(
                    'status' => 'false',
                    'response_msg' => 'No data found'
                );
                echo json_encode(array('response' => $this->response));
            }
        }
    }

    function signin_with_social() {
        header('content-type:application/json');
        $post = $_POST;
        if(isset($post['is_marketing']) && $post['is_marketing'] == 1) {
            $signup_data = ['first_name', 'last_name', 'email', 'password', 'is_marketing', 'company_name'];
        } else {
            $signup_data = ['first_name', 'last_name', 'email', 'password'];
        }

        $required = ['first_name', 'last_name', 'email', 'media_type', 'media_id'];
        if ($this->check_parameters($required)) {
            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $this->response[] = array(
                    'status' => 'false',
                    'response_msg' => 'Invalid email address',
                );
                echo json_encode(array('response' => $this->response));
                exit;
            }
            $userdata = $this->m_api->get_user_by_email($post['email']);
            if ($userdata) {
                $post['user_id'] = $userdata['user_id'];
                if ($userdata['token'] != '') {
                    $post['token'] = $userdata['token'];
                } else {
                    $post['token'] = md5(rand() . rand());
                }
                //token is valid
                $this->m_api->check_update_device_token($post);
                $update_data = elements(['user_id', 'token'], $post);
                $update_data[$post['media_type'] . '_id'] = $post['media_id'];
                $update_data['status'] = 1;

                if (isset($post['is_marketing']) && $post['is_marketing']) {
                    $update_data['is_marketing'] = $post['is_marketing'];
                }
                if (isset($post['company_name']) && $post['company_name']) {
                    $update_data['company_name'] = $post['company_name'];
                }

                if (isset($post['profile_pic']) && $post['profile_pic']) {
                    $ext1 = '.' . pathinfo($post['profile_pic'], PATHINFO_EXTENSION);
                    $ext = explode('?', $ext1);
                    $filename = date('dmyhis') . rand(1111, 9999) . strtolower($ext[0]);

                    copy(stripslashes($post['profile_pic']), '../../upload/' . $filename);
                    $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                    $update_data['profile_pic'] = $filename;
                }
                $this->m_api->update_user($update_data);
                $screen_code = $this->m_api->check_profile_complition_and_get_screen_code($userdata['user_id']);
                if ($userdata['password_updated'] == 0) {
                    //111 display update password screen
                    $screen_code = '111';
                }
                $this->response[] = array(
                    'status' => 'true',
                    'response_msg' => 'Signin successful',
                    'token' => $post['token'],
                    'screen_code' => $screen_code,
                    'user_id' => $userdata['user_id'],
                    'first_name' => $userdata['first_name'],
                    'last_name' => $userdata['last_name'],
                    'email' => $userdata['email'],
                    'phone' =>  $userdata['phone'],
                    'is_marketing' => $userdata['is_marketing'],
                    'company_name' => $userdata['company_name'],
                );
                // $this->response[] = $this->response;
                echo json_encode(array('response' => $this->response));
            } else {
                $post['token'] = md5(rand() . rand());
                

                if(isset($post['is_marketing']) && $post['is_marketing']) {
                    $signup_data = elements(['first_name', 'last_name', 'email', 'token', 'is_marketing', 'company_name'], $post);
                } else {
                    $signup_data = elements(['first_name', 'last_name', 'email', 'token'], $post);
                }

                //$signup_data['password'] = substr(md5(rand()), 1, 8);
                $signup_data[$post['media_type'] . '_id'] = $post['media_id'];
                $signup_data['status'] = 1;
                if (isset($post['phone']) && $post['phone']) {
                    $signup_data['phone'] = $post['phone'];
                }
                if (isset($post['is_marketing']) && $post['is_marketing']) {
                    $update_data['is_marketing'] = $post['is_marketing'];
                }
                if (isset($post['company_name']) && $post['company_name']) {
                    $update_data['company_name'] = $post['company_name'];
                }

                //print_r($post);
//                if(isset($post['profile_pic']) && $post['profile_pic']){
////                    echo $ext = '.' . pathinfo($post['profile_pic'], PATHINFO_EXTENSION);
////                    $filename = date('dmyhis') . rand(1111,9999). $ext;
////
////                    copy($post['profile_pic'],'../../upload/'.$filename);
////                    $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
//                    $signup_data['profile_pic'] = $post['profile_pic'];
//                    
//                }else{
//                    $signup_data['profile_pic'] = "";
//                }

                if (isset($post['profile_pic']) && $post['profile_pic']) {
                    $ext1 = '.' . pathinfo($post['profile_pic'], PATHINFO_EXTENSION);
                    $ext = explode('?', $ext1);
                    $filename = date('dmyhis') . rand(1111, 9999) . strtolower($ext[0]);

                    copy(stripslashes($post['profile_pic']), '../../upload/' . $filename);
                    $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                    $signup_data['profile_pic'] = $filename;
                } else if (isset($post['profile_pic_']) && $post['profile_pic_']) {
                    $ext1 = '.' . pathinfo($post['profile_pic_'], PATHINFO_EXTENSION);
                    $ext = explode('?', $ext1);
                    $filename = date('dmyhis') . rand(1111, 9999) . strtolower($ext[0]);

                    copy(stripslashes($post['profile_pic_']), '../../upload/' . $filename);
                    $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                    $signup_data['profile_pic'] = $filename;
                    
                    //$signup_data = elements(['name', 'email', 'token','profile_pic'], $post);                                      
                }else {
                    $signup_data['profile_pic'] = "";
                }
                $userdata = $this->m_api->signup($signup_data);
                $post['user_id'] = $userdata['user_id'];
                //check and update device token
                $this->m_api->check_update_device_token($post);

                $this->response[] = array(
                    'status' => 'true',
                    'response_msg' => 'Signin successful',
                    'token' => $post['token'],
                    'screen_code' => '222',
                    'user_id' => $userdata['user_id'],
                    'first_name' => $userdata['first_name'],
                    'last_name' => $userdata['last_name'],
                    'email' => $userdata['email'],
                    'phone' => $userdata['phone'],
                    'is_marketing' => $userdata['is_marketing'],
                    'company_name' => $userdata['company_name'],
                );
                // $this->response[] = $this->response;
                echo json_encode(array('response' => $this->response));
            }
        }
    }

    public function verify($md5_user_id) {
        $status = $this->m_api->verify($md5_user_id);
        if ($status) {
            if ($status == '1') {
                echo '<h1><font color="green">Your email has been verified. You can login to the app.</h1>';
            } else if ($status == '2') {
                echo '<h1><font color="green">Your email has been verified. You can login to the app.</h1>';
            }
        } else {
            echo '<h1><font color="red">User not registered.</h1>';
        }
    }

    public function resend_verification_mail($email = '') {
        header('Content-Type: application/json');
        $post = $_POST;

        if($email) {
            $post['email'] = $email;
        }
        if (isset($post['email']) && $post['email'] != null) {
            $userdata = $this->m_api->get_user_by_email($post['email']);
            if ($userdata) {
                if ($userdata['is_email_verified'] == 1) {
                    if(!$email) {
                        $this->response[] = array(
                            'status' => 'false',
                            'response_msg' => 'You have already verified your account, Please login',
                            'user_id' => $userdata['user_id'],
                            'email' => $userdata['email']
                        );
                    
                        echo json_encode($this->response);
                    }                    
                } else {
                  //  $userdata['team_code'] = $this->m_api->get_company_code($userdata['company_id']);

                    $userdata['otp'] = mt_rand(1000, 9999);

                    $update_data['user_id'] = $userdata['user_id'];
                    $update_data['otp'] = $userdata['otp'];
                    $this->m_api->update_user($update_data);

                    $to = $userdata['email'];
                    $subject = 'Verify your '.APP_NAME.' Account';
                    $msg = $this->load->view('mail_tmp/header', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/welcome', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/footer', $userdata, true);
                    $this->m_api->send_mail($to, $subject, $msg);

                    if(!$email) {
                        $this->response[] = array(
                            'status' => 'true',
                            'response_msg' => 'Please check your mailbox for OTP',
                            'screen_code' => '000'
                        );
                    

                        echo json_encode(array('response' => $this->response)); //JSON_PRETTY_PRINT for well formed
                    } 
                }
            } else {
                //System error cant able to generate email
                $this->response[] = array(
                    'status' => 'false',
                    'response_msg' => 'Email is not registered',
                );
                echo json_encode(array('response' => $this->response));
            }
        } else {
            //enter email
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'Please enter email',
            );
            echo json_encode(array('response' => $this->response));
        }
    }



    public function forgot_password_old() {
        header('Content-Type: application/json');
        $post = $_POST;
        if (isset($post['email']) && $post['email'] != null) {
            $userdata = $this->m_api->get_user_by_email($post['email']);
            if ($userdata) {
                if ($userdata['status'] == 0) {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'This email is not verified, Please verify your email',
                        'screen_code' => '333', //verification email
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $userdata['password'] = mt_rand(100000, 999999);

                    if ($this->m_api->generate_random_password($userdata['user_id'], $userdata['password'])) {
                        //send email
                        $to = $userdata['email'];
                        $subject = "Recover your password of " . APP_NAME;
                        $msg = $this->load->view('mail_tmp/header', $userdata, true);
                        $msg .= $this->load->view('mail_tmp/forgot_password', $userdata, true);
                        $msg .= $this->load->view('mail_tmp/footer', $userdata, true);
                        $this->m_api->send_mail($to, $subject, $msg);
                        //email sent

                        $this->response[] = array(
                            'status' => 'true',
                            'response_msg' => APP_NAME.' password has been sent to ' . $post['email'] . ' use this password to sign in and set your new password',
                        );
                        echo json_encode(array('response' => $this->response));
                    } else {
                        //System error cant able to generate new password
                        $this->response[] = array(
                            'status' => 'false',
                            'response_msg' => 'Syatem error. System can not able to generate new password.',
                        );
                        echo json_encode(array('response' => $this->response));
                    }
                }
            } else {
                //Email id not registered
                $this->response[] = array(
                    'status' => 'false',
                    'response_msg' => 'Email is not registered',
                );
                echo json_encode(array('response' => $this->response));
            }
        } else {
            //enter email
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'Please enter email',
            );
            echo json_encode(array('response' => $this->response));
        }
    }

    public function forgot_password() {
        header('Content-Type: application/json');
        $post = $_POST;
        if (isset($post['email']) && $post['email'] != null) {
            $userdata = $this->m_api->get_user_by_email($post['email']);
            if ($userdata) {
             
                    $userdata['password'] = mt_rand(1000, 9999);

                    $to = $userdata['email'];
                    $subject = "Recover your password of " . APP_NAME;
                    $msg = $this->load->view('mail_tmp/header', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/forgot_password_new', $userdata, true);
                    $msg .= $this->load->view('mail_tmp/footer', $userdata, true);
                    $this->m_api->send_mail($to, $subject, $msg);

                    if ($userdata['password']) {
                       
                        $update_data['user_id'] = $userdata['user_id'];
                        $update_data['otp'] = $userdata['password'];
                        $this->m_api->update_user($update_data);

                        $this->response[] = array(
                            'status' => 'true',
                            'response_msg' => APP_NAME.' OTP has been sent to ' . $post['email'] . ' use OTP to verify account  and set your new password',
                            'screen_code' => '333',
                            'user_id' => $userdata['user_id'],
                            'first_name' => $userdata['first_name'],
                            'last_name' => $userdata['last_name'],
                            'email' => $userdata['email'],
                            'phone' => $userdata['phone'],
                            'is_marketing' => $userdata['is_marketing'],
                            'company_name' => $userdata['company_name'],
                            'otp' => $userdata['password']
                        );
                        echo json_encode(array('response' => $this->response));
                    } else {
                        //System error cant able to generate new password
                        $this->response[] = array(
                            'status' => 'false',
                            'response_msg' => 'Syatem error. System can not able to send OTP.',
                        );
                        echo json_encode(array('response' => $this->response));
                    }
                
            } else {
                //Email id not registered
                $this->response[] = array(
                    'status' => 'false',
                    'response_msg' => 'Email is not registered',
                );
                echo json_encode(array('response' => $this->response));
            }
        } else {
            //enter email
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'Please enter email',
            );
            echo json_encode(array('response' => $this->response));
        }
    }

    public function verify_otp()
    {
        header('Content-Type: application/json');
        $post = $_REQUEST;
        //  $userdata = $this->auth();
        // if ($userdata) {
            $required =  ['user_id', 'otp'];
            if ($this->check_parameters($required)) {

                $userdata = $this->m_api->confirm_otp($post);
                if($userdata) {

                    $update_data['user_id'] = $userdata['user_id'];
                    $update_data['otp'] = "";
                    //$update_data['status'] = "1";
                    //$update_data['is_email_verified'] = "1";
                    $this->m_api->update_user($update_data);

                    if ($userdata['token'] != '') {
                        $token = $userdata['token'];
                    } else {
                        $token = md5(rand() . rand());
                    }
                    $this->m_api->update_login_token($post['user_id'], $token);

                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Successfully validate.',
                        'screen_code' => '000',
                        'token' => $token,
                        'user_id' => $userdata['user_id'],
                        'first_name' => $userdata['first_name'],
                        'last_name' => $userdata['last_name'],
                        'email' => $userdata['email'],
                        'phone' => $userdata['phone'],
                        'is_marketing' => $userdata['is_marketing'],
                        'company_name' => $userdata['company_name'],
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Invalid OTP',
                    );
                    echo json_encode(array('response' => $this->response));
                }

            }
       // }
        
    }

    function change_password() {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id', 'password'];
            if ($this->check_parameters($required)) {
                //parameters not set or null
                //old password checked

                if (isset($post['current_password']) && $post['current_password']) {
                    $check_current_password = $this->m_api->check_current_password($post);
                    if ($check_current_password) {
                        $this->response[] = array(
                            'status' => 'false',
                            'response_msg' => 'Current password does not match.',
                        );
                        echo json_encode(array('response' => $this->response));
                        exit();
                    }
                }

                $post['user_id'] = $userdata['user_id'];
                $res = $this->m_api->update_password($post);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Password updated',
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    //system error password not updated
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'System error. Password not updated.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }

    public function update_device_token() {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id', 'device_type', 'device_token'];
            if ($this->check_parameters($required)) {
                //check and update device token
                $this->m_api->check_update_device_token($post);
                $this->response[] = array(
                    'status' => 'true',
                    'response_msg' => 'Device token updated.',
                );
                echo json_encode(array('response' => $this->response));
            }
        }
    }

    function logout() {
        header('content-type:application/json');
        $post = $_POST;
        $required = ['user_id', 'device_token'];
        if ($this->check_parameters($required)) {
            $this->m_api->delete_device_token($post);
            $this->response[] = array(
                'status' => 'true',
                'response_msg' => 'User logout successfully',
            );
            echo json_encode(array('response' => $this->response));
        }
    }

    public function page($page) {
        $this->load->view($page);
    }

    public function bannerList() {
        header('Content-Type: application/json');
        $banner_list = $this->m_api->bannerList();
        if ($banner_list) {
            $this->response[] = array(
                'status' => 'true',
                'blog_list' => $banner_list,
            );
            echo json_encode(array('response' => $this->response));
            exit;
        } else {
            $this->response[] = array(
                'status' => 'false',
                'response_msg' => 'No data found.'
            );
            echo json_encode(array('response' => $this->response));
            exit;
        }
        
    }

   
    public function list_group()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id'];
            if ($this->check_parameters($required)) {
                $post['limit'] = 10;
                $post['offset'] = (isset($post['offset']) && $post['offset']) ? $post['offset'] : 0;
                $res = $this->m_api->list_group($post);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'offset' => $post['offset'] + $post['limit'],
                        'response_msg' => 'Group list.',
                        'list' => $res
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Group list not found.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }

    
    public function user_profile()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id'];
            if ($this->check_parameters($required)) {
                
                $res = $this->m_api->user_profile($post);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Profile get successfully.',
                        'list' => $res
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Cannot get profile.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }
    public function update_profile()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            if(isset($post['is_marketing']) && $post['is_marketing'] == 1) {
                $required = ['user_id', 'first_name', 'last_name', 'is_marketing', 'company_name'];
            } else {
               $required = ['user_id', 'first_name', 'last_name']; 
            }
            
            if ($this->check_parameters($required)) {
                if (isset($_FILES['profile_pic'])) {
                    $ext = '.' . pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
                    $filename = date('dmyhis') . rand() . $ext;

                    $config = array(
                        'upload_path' => '../../upload/',
                        'allowed_types' => 'gif|jpg|png|bmp|jpeg',
                        'file_name' => $filename,
                        'max_size' => '20000'
                    );

                    $this->upload->initialize($config);
                    $this->upload->do_upload('profile_pic');
                    $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                    $post['profile_pic'] = $filename;
                }
                $res = $this->m_api->update_profile($post);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Profile updated successfully.',
                        'list' => $res
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Cannot update profile.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }

    public function test_noty()
    {
        $this->load->model('m_test');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $ids = [18, 7];
        foreach ($ids as $key => $value) {
            $push = [
                'type' => '1', // new article assgin
                'to_user_id' => $value,
                'article_id' => 1,
                'notification_id' => 1,
                'message' => 'New article assigned'
            ];
        //$this->m_notify->send($push);
        $this->m_notify->send_new($push);

        }
        
    }
    public function privacy_policy()
    {
       // echo $this->m_api->privacy_policy();
        $this->load->view('privacy_policy');
    }
    public function terms_conditions()
    {
        echo $this->m_api->terms_conditions();
    }
    function contact_us() {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id', 'name', 'subject', 'message'];
            if ($this->check_parameters($required)) {
                $response = $this->m_api->contact_us($post);
                $response = true;
                if ($response) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Thank you! Your enquiry has been submitted'
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Cannot send enquiry now..!!'
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }
    function notification_setting() {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id'];
            if ($this->check_parameters($required)) {
                $setting = $this->m_api->get_user_by_id($post['user_id']);
                if($setting['notification'] == 1) {
                    $post['notification'] = 0;
                } else {
                    $post['notification'] = 1;
                }

                $response = $this->m_api->notification_setting($post);
                if ($response) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Notification setting updated.',
                        'notification' => $post['notification']
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Cannot update setting now..!!'
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }

    public function user_category()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id'];
            if ($this->check_parameters($required)) {
                
                $res = $this->m_api->user_category($post, $userdata);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Category get successfully.',
                        'list' => $res
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'No data found.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }
    public function add_user_category()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id','category'];
            if ($this->check_parameters($required)) {
                
                if (isset($_FILES['image'])) {
                    $ext = '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $filename = date('dmyhis') . rand() . $ext;

                    $config = array(
                        'upload_path' => '../../upload/',
                        'allowed_types' => 'gif|jpg|png|bmp|jpeg',
                        'file_name' => $filename,
                        'max_size' => '20000'
                    );

                    $this->upload->initialize($config);
                    $this->upload->do_upload('image');
                    $this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                    $post['image'] = $filename;
                }

                $res = $this->m_api->add_user_category($post, $userdata);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Category added successfully.',
                        //'list' => $res
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Cannot add category at the moment.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }
    public function add_contacts()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id','first_name','last_name','phone'];
            if ($this->check_parameters($required)) {

                $res = $this->m_api->add_contacts($post, $userdata);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Contact added successfully.',
                        //'list' => $res
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Cannot add Contact at the moment.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }
    public function contact_list()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id'];
            if ($this->check_parameters($required)) {

                $post['limit'] = 20;
                $post['offset'] = (isset($post['offset']) && $post['offset']) ? $post['offset'] : 0;
                $res = $this->m_api->contact_list($post, $userdata);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Contact listed successfully.',
                        'list' => $res,
                        'offset' => $post['offset'] + $post['limit'],
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Contact not  found.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }
    public function add_contact_to_category()
    {
        header('Content-Type: application/json');
        $post = $_POST;
        $userdata = $this->auth();
        if ($userdata) {
            $required = ['user_id','contact_id','category_id'];
            if ($this->check_parameters($required)) {

                $res = $this->m_api->add_contact_to_category($post, $userdata);
                if ($res) {
                    $this->response[] = array(
                        'status' => 'true',
                        'response_msg' => 'Contact added successfully.',
                    );
                    echo json_encode(array('response' => $this->response));
                } else {
                    $this->response[] = array(
                        'status' => 'false',
                        'response_msg' => 'Cannot add Contact at the moment.',
                    );
                    echo json_encode(array('response' => $this->response));
                }
            }
        }
    }

   
}
