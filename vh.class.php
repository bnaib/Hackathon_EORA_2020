<?php  /* ****************************************************************** */
      /*                                             _____ _   __           */
     /*    By: Sergey Nikolaev                      / ___// | / /          */
    /*    Сontacts: sn.prog@yandex.ru               \__ \/  |/ /          */
   /*    Created: 2020.06.06 (YYYY.MM.DD)          ___/ / /|  /          */
  /*    Updated: 2020.06.06 (YYYY.MM.DD)          /____/_/ |_/          */
 /*                                                                    */
/* ****************************************************************** */

    class VisionHub
    {
        const   MODEL_ANIME_SELFIE = 1;
        const   MODEL_ANIME_GAN = 2;
        const   MODEL_POLYGON = 3;
        const   MODEL_PIXEL_ART = 4;
        const   MODEL_FACE_BLURRING = 5;

        const   ERROR_NO = 0;
        const   ERROR_RESPONSE = 1;
        const   ERROR_FILE = 2;

        const   URL = 'https://www.visionhub.ru';
        const   URL_API = self::URL.'/api/v2';
        const   URL_AUTH = self::URL_API.'/auth/generate_token/';
        const   URL_PROCESS = self::URL_API.'/process/img2img/';
        const   URL_RESULT = self::URL_API.'/task_result/';

        private $error = self::ERROR_NO;
        private $token = null;

        public function     get_error() {return $this->error;}
        public function     get_token() {return $this->token;}

        public function    __construct($token = null)
        {
            if (!is_null($token))
            {
                $this->token = $token;
                return ;
            }
            $ch = curl_init(self::URL_AUTH.'?format=json');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($response, true);
            if (isset($json['token']))
                $this->token = $json['token'];
            else
                $this->error = self::ERROR_RESPONSE;
        }

        private function    check_model($model)
        {
            if ($this->error !== self::ERROR_NO)
            {
                throw new Exception('class VisionHub -> check_model -> '.
                    '$this->error !== self::ERROR_NO');
            }
            if ($model == self::MODEL_ANIME_SELFIE)
                return ('anime-selfie');
            if ($model == self::MODEL_ANIME_GAN)
                return ('anime_gan');
            if ($model == self::MODEL_POLYGON)
                return ('polygon');
            if ($model == self::MODEL_PIXEL_ART)
                return ('pixel-art');
            if ($model == self::MODEL_FACE_BLURRING)
                return ('face-blurring');
            throw new Exception(
                'class VisionHub -> check_model -> $model isn`t correct!');
        }

        private function    request_add_process($model, $file_id)
        {
            if ($this->error !== self::ERROR_NO)
            {
                throw new Exception('class VisionHub -> request_add_process ->'.
                    '$this->error !== self::ERROR_NO');
            }
            $post = [
                'image' => new CurlFile(
                    $_FILES[$file_id]['tmp_name'],
                    $_FILES[$file_id]['type'],
                    $_FILES[$file_id]['name']),
                'model' => $this->check_model($model)
            ];
        
            $ch = curl_init(self::URL_PROCESS);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->token));
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($response, true);
            if (isset($json['task_id']))
                return ($json['task_id']);
            else
                $this->error = self::ERROR_RESPONSE;
            return (null);
        }

        public function     add_process($model, $file_id)
        {
            if ($this->error !== self::ERROR_NO)
            {
                throw new Exception('class VisionHub -> add_process ->'.
                    '$this->error !== self::ERROR_NO');
            }
            if ($_FILES[$file_id]['error'] === 0
                && $_FILES[$file_id]['type'] === 'image/png'
                || $_FILES[$file_id]['type'] === 'image/jpeg')
                return ($this->request_add_process($model, $file_id));
            else
                $this->error = self::ERROR_FILE;
            return (null);
        }

        public function     get_result_url($task_id)
        {
            do {
                $ch = curl_init(self::URL_RESULT.$task_id.'/?format=json');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->token));
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $json = json_decode($response, true);
            } while ($json['status'] === 'IN_PROGRESS' || $json['status'] === 'NEW');
            if ($json['status'] !== 'DONE')
            {
                $this->error = self::ERROR_RESPONSE;
                return (null);
            }
            return (self::URL.$json['url']);
        }

        public function     get_result_file($result_url)
        {
            $ch = curl_init($result_url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->token));
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($response, true);
            if (!is_null($json))
            {
                $this->error = self::ERROR_RESPONSE;
                print_r($json);
                echo ('<br /><br /><br /><br />');
                return (null);
            }
            return ($response);
        }
    }
?>
