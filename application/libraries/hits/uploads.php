<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Uploads {
    function __construct() {
        
    }
    public function sanear_string($string) {
        $string = trim($string);
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'),
            $string
        );
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'i', 'i', 'i', 'i'),
            $string
        );
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'o', 'o', 'o', 'o'),
            $string
        );
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'u', 'u', 'u', 'u'),
            $string
        );
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'n', 'c', 'c',),
            $string
        );
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~", "°", "*",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "`", "]",
                "+", "}", "{", "¨", "´",
                ">", "<", ";", ",", ":"),
                '-',
            $string
        );
        $string = str_replace(
            array(' ', '_'),
            array('-'),
            $string
        );
        return $string;
    }
    public function do_upload($config_user) {
        $ci = &get_instance();
        $data = array();
        $config['upload_path'] = $config_user['upload_path'];
        $config['allowed_types'] = $config_user['allowed_types'];
        $config['max_size'] = $config_user['max_size'];
        $config['file_name'] = strtolower($this->sanear_string($_FILES['userfile']['name'][0]));
        $ci->load->library('upload', $config);
        $ci->load->library('image_lib');
        $upload_files = $_FILES;
        for($i = 0; $i < $config_user['cantidad_imagenes']; $i++) {
//            $ci->load->library('upload', $config);
            $_FILES['userfile'] = array(
                'name' => $upload_files['userfile']['name'][$i],
                'type' => $upload_files['userfile']['type'][$i],
                'tmp_name' => $upload_files['userfile']['tmp_name'][$i],
                'error' => $upload_files['userfile']['error'][$i],
                'size' => $upload_files['userfile']['size'][$i]
            );
            $error = FALSE;
            if (!$ci->upload->do_upload()) {
                $error = array('error' => $ci->upload->display_errors());
                //$ci->_aEstadoOper['message'] = $error;
            } 
            else {
                $data[$i] = $ci->upload->data();
                $data[$i]['pathCompleto'] = $config_user['upload_path'].$data[$i]['raw_name'].$data[$i]['file_ext'];
                if($config_user['create_thumb']) {
                    foreach ($config_user['thumbs'] as $thumb) {
                        $configa['create_thumb'] = $config_user['create_thumb'];
                        $configa['maintain_ratio'] = TRUE;
                        $configa['new_image'] = $config_user['upload_path'];
                        $configa['source_image'] = $config_user['upload_path'].$data[$i]['raw_name'].$data[$i]['file_ext'];
                        $configa['thumb_marker'] = $thumb['thumb_marker'];
                        $configa['width'] = $thumb['width'];
                        $configa['height'] = 1;
                        $configa['master_dim'] = 'width';
                        $ci->image_lib->initialize($configa);
                        if($ci->image_lib->resize()) {
                            $nombreThumbnail = $data[$i]['raw_name'].$thumb['thumb_marker'].$data[$i]['file_ext'];
                            $data[$i]['thumbnails'][] = array('nombreThumbnail' => $nombreThumbnail, 'pathThumbnail' => $config_user['upload_path'].$nombreThumbnail);
                        }
                        else {
                            //$data['thumbnails'][] = array_merge($this->errors, array($image->error->string));
                        }
                        $configa = array();
                        $ci->image_lib->clear();
                    }
                    $ci->image_lib->clear();
                }
            }
        }
        $data['error'] = $error;
        return $data;
    }
    public function delete_image($path) {
        if(unlink($path)) {
            $msg = 'Se ha eliminado la imagen correctamente';
        }
        else {
            $msg = 'No se ha podido eliminar la imagen';
        }
        return $msg;
    }
    
}
?>