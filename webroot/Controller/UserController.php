<?php

require(dirname(__FILE__) . '/../Model/User.php');
require(dirname(__FILE__) . '/../Controller/ApiController.php');

class UserController implements ApiController{

    public static function get($id = null) {
        $data = User::getUsers($id);
        echo json_encode(array('status' => API_STATUS_SUCCESS, 'data' => $data));
    }

    public static function put($id) {
        if ((int) $id) {
            parse_str(file_get_contents("php://input"),$_PUT);

            $name = isset($_PUT['name']) ? $_PUT['name'] : '';
            $picture = isset($_PUT['picture']) ? $_PUT['picture'] : '';
            $address = isset($_PUT['address']) ? $_PUT['address'] : '';
            $result = User::updateUser($id, $name, $picture, $address);
            echo json_encode($result);
        }
    }

    public static function post() {
        if ($_POST) {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $picture = self::_uploadUserPicture();
            $result = User::addUser($name, $picture, $address);
            echo json_encode($result);
        }
    }

    public static function delete($id) {
        if ((int) $id) {
            $result = User::deleteUser($id);
            echo json_encode($result);   
        }
    }


    private static function _uploadUserPicture() {
        $picture = '';
        if (isset($_FILES['picture'])) {
            $file_name_with_full_path = $_FILES['picture']['tmp_name'];
            $curl_handle = curl_init(OLX_API_PICTURE_URL);              
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            $args['file'] = new CurlFile($file_name_with_full_path, 'image/png');
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $args); 
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);            
            //execute the API Call
            $response = curl_exec($curl_handle);
            curl_close ($curl_handle);
            $response = json_decode($response);
            $picture = OLX_PICTURE_PATH . $response->url;
        }
        return $picture;
    }
    
} 