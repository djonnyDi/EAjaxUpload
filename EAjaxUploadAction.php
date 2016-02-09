<?php
 namespace app\widgets\EAjaxUpload;
 use yii\base\Action;



class EAjaxUploadAction extends Action
{
public $uploadPath = '/upload';
        public function run()
        {
                // list of valid extensions, ex. array("jpeg", "xml", "bmp")
                $allowedExtensions = array("jpg","bmp","png");
                // max file size in bytes
                $sizeLimit = 1 * 1024 * 1024;

                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $this->uploadPath = \Yii::$app->basePath.'/'.$this->uploadPath;
                $result = $uploader->handleUpload($this->uploadPath);
                // to pass data through iframe you will need to encode all html tags
                $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $result;
        }
}
