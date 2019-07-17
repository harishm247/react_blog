<?php
require APPPATH.'third_party/Auth/JWT.php';

class AUTHORIZATION
{
    public static function validateTimestamp($token)
    {
        $CI =& get_instance();
        $token = self::validateToken($token);
        if ($token != false && (now() - $token->timestamp < ($CI->config->item('token_timeout') * 60))) {
            return $token;
        }
        return false;
    }

    public static function validateToken($token)
    {
        $CI =& get_instance();
        $list = JWT::decode($token, $CI->config->item('jwt_key'));
        if ($list!= false) {
           if($list->timestamp > date("Y-m-d H:i:s")){
                return $list;
            }else{
                return false;  
            }
        }else{
            return false;  
        }
    }

    public static function generateToken($data)
    {
        $CI =& get_instance();
        $data['timestamp'] =  date("Y-m-d H:i:s", strtotime("+9 hours"));
        return JWT::encode($data, $CI->config->item('jwt_key'));
    }

}