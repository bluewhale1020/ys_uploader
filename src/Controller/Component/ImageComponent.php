<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

use Cake\ORM\TableRegistry;

use RuntimeException;

/**
 * ImageComponent component
 * 
 * osolete replaced by Preview Component
 * 
 */
class ImageComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * This array stores all allowed mime types, a mime type
     * determines the type of file.
     *
     * The specified mime types below should be safe for uploads,
     * however the compressed formats could be a touch unsafe.
     *
     * This can be overwritten by setAllowedMime()
     */        

    var $_allowedMime = [];
    
    public function initialize(array $config) {
        /*初期処理*/
        $this->MimeTypes = TableRegistry::get("MimeTypes");
        
        $this->_allowedMime = $this->MimeTypes->createAllowedMimeArray();
        
    }    
                       
    public function getImageData($file){
        
        if(empty($file)){
            return false;
        }
        
     if(empty($dir)){
        $dir = realpath(WWW_ROOT .DS . "files");      
    }
    
    $hash_name = $file['hash_name'];
    $filename = $file['file_name'];
    
   // ダウンロードファイルフルパス
    //Windows folder 日本語文字化け対策 ファイル名をSJISに
       $file_path = $dir . DS . $hash_name; 

    //拡張子取得
    if(!empty($this->_allowedMime[$file['mime_type']])){
        $ext = $this->_allowedMime[$file['mime_type']];
        
        if(!in_array($ext, array("jpg","png","tiff","gif","pjpeg","bmp"))){
            return false;
        }
        
    }else{
        return false;
    }    
  

        $response = $this->response->withFile($file_path, ['download' => false, 'name' => $filename]);
        return $response;      
        
        
    }
    
    
 
    
    
}
