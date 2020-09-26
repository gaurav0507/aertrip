<?php
class AUTHORIZATION
{
    private static function validateToken($token)
    {
      try
      {
        $CI =& get_instance();

        return JWT::decode($token, $CI->config->item('jwt_key'));
      }
      catch(Exception $e)
      {
        return FALSE;
      }
    }

    public static function generateToken($data)
    {
      try
      {
        $CI =& get_instance();

        return JWT::encode($data, $CI->config->item('jwt_key'));
      }
      catch(Exception $e)
      {
        return FALSE;
      }

    }

    public static function generate_refresh_token($data)
    {
      try
      {
        $CI =& get_instance();

        return JWT::encode($data, $CI->config->item('refresh_token_key'));
      }
      catch(Exception $e)
      {
        return FALSE;
      }
    }

    public static function get_access_token_header()
    {
      $CI =& get_instance();

      $headers = $CI->input->request_headers();

      if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
      {
        return  $headers['Authorization'];
      }
      else
      {
        return FALSE;
      }
    }

    public static function decode_refresh_token($token)
    {
        try
        {
          $CI =& get_instance();

          return JWT::decode($token, $CI->config->item('refresh_token_key'));
        }
        catch(Exception $e)
        {
          return FALSE;
        }
    }

    public static function get_refresh_token_header()
    {
      $CI =& get_instance();

      $headers = $CI->input->request_headers();

      if (array_key_exists('Refresh', $headers) && !empty($headers['Refresh']))
      {
        return  $headers['Refresh'];
      }
      else
      {
        return FALSE;
      }
    }

    public static function generate_password($str)
    {
      $options = ['cost' => 12];

      return  password_hash($str, PASSWORD_BCRYPT, $options);
    }

    public static function encrypt_for_url($str)
    {
      $CI =& get_instance();

      $CI->load->model('default_m');

      return $CI->default_m->encrypt($str);
    }

    public static function decrypt_for_url($str)
    {
      $CI =& get_instance();

      $CI->load->model('default_m');

      return $CI->default_m->decrypt($str);
    }

    public static function is_valid_request_token($token = NULL)
    {
      if($token = SELF::get_access_token_header())
      {
        return SELF::validateToken($token);
      }
      else
      {
        return FALSE;
      }
    }

    public static function is_expired_token()
    {
      $CI =& get_instance();

      $CI->load->model('auth_model');

      try
      {
        return $CI->auth_model->is_expired_access_token(SELF::get_access_token_header());

      }catch (Exception $e)
      {
        return TRUE;
      }

    }

    public static function inspect_request_token_data()
    {
      $CI =& get_instance();

      $token_data = SELF::is_valid_request_token();

      if(!$token_data)
      {
        $json_array['status'] = FALSE;

        $json_array['message'] = 'Invalid token';

        $CI->response($json_array,REST_Controller::HTTP_UNAUTHORIZED);
      }

      $is_expired = SELF::is_expired_token();

      if($is_expired)
      {
        $json_array['status'] = FALSE;

        $json_array['message'] = 'Token is expired';

        $CI->response($json_array,REST_Controller::HTTP_UNAUTHORIZED);
      }

      $token_data = (array) $token_data;

      if(empty($token_data['id']) OR !is_numeric($token_data['id']) OR empty($token_data['device_id']))
      {
        $json_array['status'] = FALSE;

        $json_array['message'] = 'Invalid token';

        $CI->response($json_array,REST_Controller::HTTP_UNAUTHORIZED);
      }

      return $token_data;
    }

}
