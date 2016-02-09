# EAjaxUpload
yii2 ajax uploader 
Installation: extract the release file under app/widgets/

View: \app\widgets\EAjaxUpload\EAjaxUpload::widget([
            'id' => 'uploadFile',
            'action' => '/admin/upload',
            'config'=>[
                'debug' => false,
                'multiple' => false,
                'autoUpload' => true,
                'validation' =>[
                    'allowedExtensions' => [
                        "jpg",
                        "jpeg",
                        "png"
                    ],
                    'sizeLimit'=>100*1024*1024,// maximum file size in bytes
                ],
                'callbacks' =>[
                    'onComplete' => "js:function(id, name, response){...}",
                ],
                'params' => null,
            ]]);
            
 Controller: 
          public function actions()
            {
                return [
                    'upload' => [
                        'class' => EAjaxUploadAction::className(),
                        'uploadPath' => 'web/tmp/',
        
                    ],
        
                ];
            }
