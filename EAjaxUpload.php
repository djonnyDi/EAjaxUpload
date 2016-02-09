<?php
/**
 * EAjaxUpload class file.
 * This extension is a wrapper of http://valums.com/ajax-upload/
 *
 * @author Vladimir Papaev <kosenka@gmail.com>
 * @version 0.1
 * @license http://www.opensource.org/licenses/bsd-license.php
 */


namespace app\widgets\EAjaxUpload;
use  yii\base\Exception;
use yii\web\JqueryAsset;
use yii\web\JsExpression;
use yii\web\View;
use \Yii;
use yii\helpers\Json;

class EAjaxUpload extends \yii\base\Widget
{
    public $id="fileUploader";
    public $action = '/upload';
	public $postParams=array();
	public $config=array();
	public $css=null;

        public function run(){
//		if(empty($this->config['action']))
//		{
//		      throw new Exception('EAjaxUpload: param "action" cannot be empty.');
//                }

//		if(empty($this->config['allowedExtensions']))
//		{
//		      throw new Exception('EAjaxUpload: param "allowedExtensions" cannot be empty.');
//                }

//		if(empty($this->config['sizeLimit'])){
//		      throw new Exception('EAjaxUpload: param "sizeLimit" cannot be empty.');
//        }

        unset($this->config['element']);


            $assets = dirname(__FILE__).'/assets';

            $baseUrl = Yii::$app->getAssetManager()->publish($assets);
            $baseUrl = $baseUrl[1];

            $this->getView()->registerJsFile($baseUrl . '/fileuploader.js',['depends' => [JqueryAsset::className()]]);
	        $this->css=(!empty($this->css))?$this->css:$baseUrl.'/fileuploader.css';
            $this->getView()->registerCssFile($this->css);
            //// Formated config plugin






            $config = ['element' => "js:document.getElementById('$this->id')",];
            $config ['request']= [
                'endpoint'=> $this->action,
                'params'=>[
                    '_csrf' => Yii::$app->request->csrfToken],
            ];
            $config = array_merge($this->config,$config);

        $config = $this->convertPhpJs($config);
        $config = Json::encode($config);

        $this->getView()->registerJs(" var FileUploader_".$this->id." = new qq.FineUploader($config);",View::POS_END);
	}

    private function convertPhpJs($conf){
        foreach($conf as &$item){
           if(is_string($item) && strpos($item,'js:') !== false){

                $js = str_replace('js:','',$item);

                $item = new JsExpression($js);


            }elseif(is_array($item)){
               $item = $this->convertPhpJs($item);
           }
        }

        return $conf;
    }
}