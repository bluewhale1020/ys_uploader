<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

use Cake\ORM\TableRegistry;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;

/**
 * FileHandler component
 */
class FileHandlerComponent extends Component
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
    var $_allowedAmbiguousMime = [];
    
    public function initialize(array $config) {
        /*初期処理*/
        $this->MimeTypes = TableRegistry::get("MimeTypes");
        
        $this->_allowedAmbiguousMime = $this->MimeTypes->createAllowedAmbiguousMimeArray();
        $this->_allowedMime = $this->MimeTypes->createAllowedMimeArray();
        
    }    
                       
    
    public function getAllowedMime(){
        $valArray = array_values($this->_allowedMime);
        $mimeList = array();
        foreach ($valArray as $key => $value) {
            $mimeList[$value]=$value;
        }
    
            return $mimeList;
        
    }
    
    public function getFullMimeTypesFromExt($ext){
        $result = array_keys($this->_allowedMime, $ext);
        $mimeTypes = [];
        foreach ($result as $idx => $mimetype) {
            $mimeTypes[] = "'".$mimetype ."'";
        }
        
        return implode(",", $mimeTypes) ;
        
        
    }

    public function file_upload ($file = null,$dir = null, $limitFileSize = 1048576){
        try {
            // ファイルを保存するフォルダ $dirの値のチェック
            if ($dir){
                if(!file_exists($dir)){
                    throw new RuntimeException('指定のディレクトリがありません。');
                }
            } else {
                throw new RuntimeException('ディレクトリの指定がありません。');
            }
 
            // 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
            if (!isset($file['error']) || is_array($file['error'])){
                throw new RuntimeException('無効なパラメーターです。');
            }
 
            // エラーのチェック
            switch ($file['error']) {
                case 0:
                    break;
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('ファイルが送信されていません。');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('許容ファイルサイズ（'.$limitFileSize.'）を超えています。');
                default:
                    throw new RuntimeException('不明なエラーです。');
            }
 
            
            
 
            // ファイル情報取得
            $fileInfo = new File($file["tmp_name"]);
 
            // ファイルサイズのチェック
            if ($fileInfo->size() > $limitFileSize) {
                throw new RuntimeException('許容ファイルサイズ（'.$limitFileSize.'）を超えています。');
            }

            //ファイルタイプを取得
            $mime_type = mime_content_type($file["tmp_name"]);
            if(in_array($mime_type, $this->_allowedAmbiguousMime) ){
                $mime_type = $file["type"];
            }
 
            // ファイルタイプのチェックし、拡張子を取得
            if(!empty($this->_allowedMime[$mime_type])){
                $ext = $this->_allowedMime[$mime_type];
            }else{
                throw new RuntimeException('このファイルの形式には対応していません。');
            }
 
            // ファイル名の生成
            //Windows folder 日本語文字化け対策 ファイル名をSJISに
            //$uploadFile = $this->conv_sjis_auto($file["name"]);
            $hashName = sha1_file($file["tmp_name"]) . "." . $ext;
 
             // if (strpos($uploadFile, '\\') !== false ) {
                // throw new RuntimeException('そのファイル名では保存できません。ファイル名は出来るだけアルファベットをご利用ください。');
            // }  
 
            // ファイルの移動
            if (!@move_uploaded_file($file["tmp_name"], $dir . DS . $hashName)){
                throw new RuntimeException('ファイルの移動に失敗しました。');
            }
 
            // 処理を抜けたら正常終了
//            echo 'File is uploaded successfully.';
 
        } catch (RuntimeException $e) {
            throw $e;
        }
        return $hashName; //ファイル名 UTF-8
    }    
    
    public function conv_sjis_auto($filename){
        
        return mb_convert_encoding($filename, "SJIS", "AUTO");
       
    }

    public function file_download($file = null,$dir){
        //debug($_POST['']); 
    if(empty($file)){
        throw new RuntimeException('指定のファイルがありません。');
    }  

    if(empty($dir)){
        $dir = realpath(TMP .DS . "uploads");      
    }
    
    $hash_name = $file['hash_name'];
    $filename = $file['file_name'];
    
   // ダウンロードファイルフルパス
    //Windows folder 日本語文字化け対策 ファイル名をSJISに
       $file_path = $dir . DS . $hash_name; 

    //拡張子取得
    if(!empty($this->_allowedMime[$file['mime_type']])){
        $ext = $this->_allowedMime[$file['mime_type']];
    }else{
        throw new RuntimeException('このファイルの形式には対応していません。');
    }    
  


        // ファイルがcake/app/webroot/files以下にあるとき
        // WWW_ROOT, DS は定数 公式サイト参照
        //$file_path = WWW_ROOT.'files'.DS.$file_name;

        
        //ファイルの種類によってContent-Typeを指定　後述するfirefoxのため。
        //$this->response->type($ext);
        
        // response->file()でダウンロードもしくは表示するファイルをセット
        //$this->response->file($file_path);
        

        // 単にダウンロードさせる場合はこれを使う
        //$this->response->download($filename);       
        

        $response = $this->response->withFile($file_path, ['download' => true, 'name' => $filename]);
        return $response;
        
             
    }
    
    
}
