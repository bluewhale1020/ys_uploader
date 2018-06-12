<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

use Cake\ORM\TableRegistry;

use Cake\Filesystem\File;

use Dompdf\Dompdf;
use PhpOffice\PhpWord\Settings as WordSettings;
use PhpOffice\PhpWord\IOFactory as WordFactory;
use PHPExcel_IOFactory;


use RuntimeException;

/**
 * PreviewComponent component
 */
class PreviewComponent extends Component
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

    protected $_allowedMime = [];
    protected $_fileType = "";
    protected $filepath;
    protected $filename;
    protected $hash_name;
    protected $ext;
    protected $responseData;
    protected $dir; 
    protected $has_temp_file = false;
    
    public function initialize(array $config) {
        /*初期処理*/
        $this->MimeTypes = TableRegistry::get("MimeTypes");
        
        $this->_allowedMime = $this->MimeTypes->createAllowedMimeArray();
        
        $this->dir = realpath(TMP .DS . "uploads"); 
    }    
    
    private function setFileType($mime_type = null){
        
        if(empty($mime_type)){
            return false;
        }
        
        //拡張子取得
        if(!empty($this->_allowedMime[$mime_type])){
            $this->ext = $this->_allowedMime[$mime_type];
            
            if(in_array($this->ext, array("jpg","png","tiff","gif","pjpeg","bmp"))){
                $this->_fileType = 'image';
            }elseif(in_array($this->ext, array("pdf","acrobat"))){
                $this->_fileType = 'pdf';
            }elseif(in_array($this->ext, array("txt","csv"))){
                $this->_fileType = 'text';
            }elseif(in_array($this->ext, array("docx"))){//"doc",docは非対応
                $this->_fileType = 'word';
            }elseif(in_array($this->ext, array("xls","xlsx"))){
                $this->_fileType = 'excel';
            }else{
                $this->_fileType = '';
            }
            
        }   
    }
    
    private function returnPreviewData(){
        return $this->responseData;        
    }
    
    private function setResponseData(){
        $this->responseData = $this->response->withFile($this->filepath, ['download' => false, 'name' => $this->filename]);
        
    }
    
    // public function clearInstances(){
        // if(method_exists($this->responseData,'clear')){
            // //$this->responseData->clear();
        // }
        // if($this->getFileType() != 'image'){
            // //unlink($this->filepath);
        // }
//         
//         
    // }
    
    public function deleteTempFile(){
            
            if($this->has_temp_file == true){
                $del_file = new File($this->filepath);
                // ファイル削除処理実行
                if ($del_file->exists()) {
                    // ファイルがある時の処理
                    if(!$del_file->delete()) {
                        //throw new RuntimeException('ファイルの物理削除ができませんでした.');
                    }else{
                        $this->has_temp_file = false;
                    }
                }                
            }
            
       
        
    }
    
    public function getPreviewData($file){
        if(empty($file)){
            return false;
        }
        
     // if(empty($dir)){
        // $dir = realpath(TMP .DS . "uploads");      
    // }
    
    $this->hash_name = $file['hash_name'];
    $this->filename = $file['file_name'];
    
   // ダウンロードファイルフルパス
    //Windows folder 日本語文字化け対策 ファイル名をSJISに
       $this->filepath = $this->dir . DS . $this->hash_name;         
       
       //ファイルタイプ取得
       $this->setFileType($file['mime_type']);
       
       if(empty($this->_fileType)){
           return false;
       }
       
       //ファイルタイプで処理を選択
       switch ($this->_fileType) {
           case 'image':
               $this->setResponseData(); 
               break;         
           case 'pdf':
               $this->convPdfImage();
               break;
           case 'text':
               $this->convTxtPdf();
               $this->convPdfImage();
               $this->has_temp_file = true;               
               break;
            case 'word':
               $this->convWordPdf();
               $this->convPdfImage();
               $this->has_temp_file = true;                
               break; 
            case 'excel':
               $this->convExcelHtml();
               //$this->setResponseData();
               //$this->has_temp_file = true; 
               break;                         
           default:
               break;
               
       }
       
       
       
       return $this->returnPreviewData();
        
    }


    private function convExcelHtml(){
        $html_path = $this->dir . DS .$this->hash_name . '.html';
        
        if($this->ext == 'xlsx'){
            $inputFileType = "Excel2007";
        }else{
            $inputFileType = "Excel5";
        }
        
        /**  Create a new Reader of the type defined in $inputFileType  **/ 
        $objReader = PHPExcel_IOFactory::createReader($inputFileType); 
        /**  Read the list of worksheet names and select the one that we want to load  **/
        $worksheetList = $objReader->listWorksheetNames($this->filepath);
        $sheetname = $worksheetList[0]; 
        
        /**  Advise the Reader of which WorkSheets we want to load  **/ 
        $objReader->setLoadSheetsOnly($sheetname); 
        /**  Load $inputFileName to a PHPExcel Object  **/ 
        $book = $objReader->load($this->filepath); 



        $writer = PHPExcel_IOFactory::createWriter($book, 'HTML');
    
        //$writer->save($html_path);
         ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();    
        
        $this->responseData = $excelOutput;
        
        //$this->filepath = $html_path;
    }

    private function convWordPdf(){
        $pdf_path = $this->dir . DS .$this->hash_name . '.pdf';
        
        $domPdfPath =  ROOT . DS . 'vendor' . DS . 'dompdf' . DS . 'dompdf';
        //$domPdfPath = realpath(__DIR__ . '/vendor/dompdf/dompdf');
        WordSettings::setPdfRendererPath($domPdfPath);
        WordSettings::setPdfRendererName('DomPDF');
        
        
        $phpWord = WordFactory::load($this->filepath);
        //
        
        
        $pdfWriter = WordFactory::createWriter( $phpWord, 'PDF' );
        
        
        $pdfWriter->save($pdf_path);        
        
        $this->filepath = $pdf_path;
    }    
    
    
    private function convert_encoding_text($testData){
        //check string strict for encoding out of list of supported encodings
        $enc = mb_detect_encoding($testData, mb_list_encodings(), true);
        //debug($enc);
        if ($enc===false){
            //could not detect encoding
            return $testData;
        }
        else if ($enc!=="UTF-8"){
            return mb_convert_encoding($testData, "UTF-8", $enc);
        }
        else {
            //UTF-8 detected
            return $testData;
        }        
    }
    
    private function convTxtPdf(){
        
        $pdf_path = $this->dir . DS .$this->hash_name . '.pdf';
        
        $pdf = new Dompdf;
        $list = file_get_contents($this->dir . DS . $this->hash_name);
        
        
        
        $list = $this->convert_encoding_text($list);
        //$list = mb_convert_encoding($list, "UTF-8","SJIS");
        $data = '';
        //$list = @file_get_contents($filePath);
        $list = explode("\n", $list);
        foreach($list as $str){
            $data .= $str . "<br />";
        }
        
        
        
        $html = <<< EOF
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"  lang="ja">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <title>Bitnami: Open Source. Simplified</title>
        <style>
         body {
            font-family: ipag;
        }   
        </style>
          
        </head>
        <body>
        ${data}
        </body>
        </html>       
EOF;

//print($html);die();
        
        $pdf->loadHtml($html);
        //$pdf->set_option('enable_font_subsetting', true);
        $pdf->set_option('defaultFont', 'ipag');
        $pdf->render();
        //ファイル出力の場合
        file_put_contents($pdf_path, $pdf->output());        
        
        $this->filepath = $pdf_path;
    }
    
    
      private function convPdfImage(){
          
          $this->responseData = new \Imagick();
          
        // 読み込む PDF をフルパスで指定
        //$file = 'C:\xampp\htdocs\PHPProject\test_imagick\report.pdf';
        
        // サムネイルを作成するページを指定
        //$page = 2;
        
        // 実際の指定では、1ページが0になるので、調整
        //$page = $page - 1;
        
        
        //this must be called before reading the image, otherwise has no effect
        //$im->setResolution(800,800);
        //read the pdf
        $path = $this->filepath;
        $this->responseData->readImage("${path}[0]");
        
         
        // PNG 形式に変換
        $this->responseData->setImageFormat("png");
        
        // 長辺が 300 ピクセルになるようにリサイズ
        $this->responseData->thumbnailImage(600, 600, true);
        
        $this->_fileType = "pdfimage";      
    }  

    public function getFileType(){
        return $this->_fileType;
    }
 
    
    
}