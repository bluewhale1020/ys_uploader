<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

use Cake\ORM\TableRegistry;

use Cake\Filesystem\File;

use Dompdf\Dompdf;
use PhpOffice\PhpWord\Settings as WordSettings;
use PhpOffice\PhpWord\IOFactory as WordFactory;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Settings;
use PHPExcel_Cell;
use PHPExcel_CachedObjectStorageFactory;

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
    protected $output_filename;
    protected $filename;
    protected $hash_name;
    protected $ext;
    protected $responseData;
    protected $dir; 
    protected $has_temp_file = false;
    protected $has_preview = false;
    
    protected $COLUMNS = 600;
    protected $ROWS = 600;
    
    public function initialize(array $config) {
        /*初期処理*/
        $this->MimeTypes = TableRegistry::get("MimeTypes");
        
        $this->_allowedMime = $this->MimeTypes->createAllowedMimeArray();
        
        $this->dir = realpath(WWW_ROOT .DS . "files"); 
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
    
    public function getPreviewData($file,$conv_to_image = false){
        if(empty($file)){
            return false;
        }
        
     // if(empty($dir)){
        // $dir = realpath(WWW_ROOT .DS . "files");      
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
               if($conv_to_image){
                   $this->convPdfImage();
               }else{
                   $this->has_preview = true;
                   $this->_fileType = "pdf";
                   $this->output_filename = $this->hash_name;
               }
               
               
               break;
           case 'text':
               $this->convTxtPdf();
               if($conv_to_image){
                   $this->convPdfImage();
               } else{
                   $this->has_preview = true;
                   $this->_fileType = "pdf";                   
               }              
               
               $this->has_temp_file = true;               
               break;
            case 'word':
               $this->convWordPdf();
               if($conv_to_image){
                   $this->convPdfImage();
               } else{
                   $this->has_preview = true;
                   $this->_fileType = "pdf";                   
               }                
               
               $this->has_temp_file = true;                
               break; 
            case 'excel':
                $this->convExcelPdf();
               if($conv_to_image){
                   $this->convPdfImage();
               } else{
                   $this->has_preview = true;
                   $this->_fileType = "pdf";                   
               }                
               
               $this->has_temp_file = true;                
                
               //HTMLで出力する 
               //$this->convExcelHtml();

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
        
    }

    private function convExcelPdf(){
        $pdf_path = $this->dir . DS .$this->hash_name . '.pdf';
        
        if(!file_exists($pdf_path)){
 
 
 //using Cache to reduce memory usage
$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
$cacheSettings = array( ' memoryCacheSize ' => '3MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
            
            if($this->ext == 'xlsx'){
                $inputFileType = "Excel2007";
            }else{
                $inputFileType = "Excel5";
            }
            
            /**  Create a new Reader of the type defined in $inputFileType  **/ 
            $objReader = PHPExcel_IOFactory::createReader($inputFileType); 
            /**  Read the list of worksheet names and select the one that we want to load  **/
            //$worksheetList = $objReader->listWorksheetNames($this->filepath);
            //$sheetname = $worksheetList[0]; 
            
            /**  Advise the Reader of which WorkSheets we want to load  **/ 
            //$objReader->setLoadSheetsOnly($sheetname); 
            /**  Load $inputFileName to a PHPExcel Object  **/ 
            $book = $objReader->load($this->filepath);             
            

//ini_set('memory_limit', '512M'); // or you could use 1G

    $objPHPExcel_des = new PHPExcel();
 


    $objSheet = $book->getSheet(0)->copy();  



    $highestRow = $objSheet->getHighestRow();
    
    if($highestRow > 30){
      //$newSheet = $book->getSheet(0); 
        
        $objPHPExcel_des->setActiveSheetIndex( 0 );
        $sheet_des = $objPHPExcel_des->getActiveSheet();     
     
        $this->copySheetRowsOld($objSheet,$sheet_des,0,0,30);   
    }else{
        $objPHPExcel_des->addExternalSheet($objSheet);
        $objPHPExcel_des->removeSheetByIndex(0);
        
         $objPHPExcel_des->setActiveSheetIndex( 0 );
     
    }

    $book->disconnectWorksheets();
    unset($book);

    $objPHPExcel_des->getActiveSheet()->setShowGridlines(false); 
 


            // DomPDF
            // PHPExcel_Settings::setPdfRenderer(
                // PHPExcel_Settings::PDF_RENDERER_DOMPDF,
                // ROOT .'/vendor/dompdf/dompdf'
            // );            
             // tcPDF
            PHPExcel_Settings::setPdfRenderer(
                PHPExcel_Settings::PDF_RENDERER_TCPDF,
                ROOT .'/vendor/tecnickcom/tcpdf'
            );                 
           
            // Write PDF
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel_des, 'PDF');
            $objWriter->setFont('kozgopromedium');//$objWriter->setFont('arialunicid0-japanese');            
            $objWriter->save($pdf_path);            


                       
        }
        
        
        
        $this->output_filename = $this->hash_name . '.pdf';
        
        $this->has_preview = true;
    }  


/**
 * 指定した行を別シートにコピー
 * 
 * @param obj  $srcSheet 挿入元シート
 * @param obj  $dstSheet 挿入先シート
 * @param int  $srcRow 複製元行番号
 * @param int  $dstRow 複製先行番号
 * @param int  $height 複製行数（複製元シート）
 * @param int  $width 複製カラム数（複製元シート）
 * @throws PHPExcel_Exception
 */
private function copySheetRowsOld($srcSheet,$dstSheet, $srcRow = 0, $dstRow = null, $height = null, $width = null) {

    if(!isset($dstRow)){
        //複製先シート行番号が未指定の場合、最大行数＋１を挿入
        $dstRow = $dstSheet->getHighestRow() + 1;
    }
    if(!isset($height)){
        //Heightが0で指定された場合、挿入元シートの最大行を指定する。
        $height = $srcSheet->getHighestRow();
    }
    if(!isset($width)){
        //Widthが0で指定された場合、挿入元シートの最大列を指定する。
        $width = PHPExcel_Cell::columnIndexFromString($srcSheet->getHighestColumn()) - 1;
    }
 
    for ($row = 0; $row < $height; $row++) {
        // セルの書式と値の複製
        for ($col = 0; $col < $width; $col++) {
            $srcCellPath = PHPExcel_Cell::stringFromColumnIndex($col) . (string) ($srcRow + $row);
            $dstCellPath = PHPExcel_Cell::stringFromColumnIndex($col) . (string) ($dstRow + $row);
 
            $srcCell = $srcSheet->getCell($srcCellPath);
            //$srcStyle = $srcSheet->getStyle($srcCellPath);

            $cell = $srcCell->getValue();
                    if($cell instanceof PHPExcel_RichText)     //richText with color etc 
                        $cell = $cell->__toString();  
                    if(substr($cell,0,1)=='='){ //with fomula
                        try{
                            if($srcCell->getCalculatedValue() == '#REF!' || $srcCell->getCalculatedValue() == '#VALUE!')
                            {
                                $cell = $srcCell->getOldCalculatedValue();
                            }
                                else
                            {
                                $cell= $srcCell->getCalculatedValue();
                            }
                        }catch(Exception $e){
                            $cell = $srcCell->getOldCalculatedValue();
                        }
            }
             
            //値のコピー
            $dstSheet->setCellValueByColumnAndRow($col, $dstRow + $row, $cell);
             
            //書式コピー
            //$dstSheet->duplicateStyle($srcStyle, $dstCellPath);      
            
        }
 
        // 行の高さ複製。
        $h = $srcSheet->getRowDimension($srcRow + $row)->getRowHeight();
        $dstSheet->getRowDimension($dstRow + $row)->setRowHeight($h);
    }
     
    // セル結合の複製
    foreach ($srcSheet->getMergeCells() as $mergeCell) {
        $mc = explode(":", $mergeCell);
        $col_s = preg_replace("/[0-9]*/", "", $mc[0]);
        $col_e = preg_replace("/[0-9]*/", "", $mc[1]);
        $row_s = ((int) preg_replace("/[A-Z]*/", "", $mc[0])) - $srcRow;
        $row_e = ((int) preg_replace("/[A-Z]*/", "", $mc[1])) - $srcRow;
         
        // 複製先の行範囲
        if (0 <= $row_s && $row_s < $height) {
            $merge = $col_s . (string) ($dstRow + $row_s) . ":" . $col_e . (string) ($dstRow + $row_e);
            $dstSheet->mergeCells($merge);
        }
        unset($mc);
    }
}



    private function convWordPdf(){
        $pdf_path = $this->dir . DS .$this->hash_name . '.pdf';
        
        if(!file_exists($pdf_path)){
            $domPdfPath =  ROOT . DS . 'vendor' . DS . 'dompdf' . DS . 'dompdf';
            //$domPdfPath = realpath(__DIR__ . '/vendor/dompdf/dompdf');
            //WordSettings::setPdfRendererPath($domPdfPath);
            //WordSettings::setPdfRendererName('DomPDF');
 

             $tcPdfPath =  ROOT . DS . 'vendor' . DS . 'tecnickcom' . DS . 'tcpdf';
            //$domPdfPath = realpath(__DIR__ . '/vendor/dompdf/dompdf');
            WordSettings::setPdfRendererPath($tcPdfPath);
            WordSettings::setPdfRendererName('TCPDF');           
            
            $phpWord = WordFactory::load($this->filepath);
            //
            
            
            $pdfWriter = WordFactory::createWriter( $phpWord, 'PDF' );
            $pdfWriter->setFont('kozgopromedium');
            
            $pdfWriter->save($pdf_path);            
        }
        
        
        
        $this->output_filename = $this->hash_name . '.pdf';
        
        $this->has_preview = true;
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

        if(!file_exists($pdf_path)){
            $pdf = new Dompdf;
            $list = file_get_contents($this->dir . DS . $this->hash_name,false, null, 0, 3000);
            
            
            
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
        }
        
       
        
        $this->output_filename = $this->hash_name . '.pdf';

        $this->has_preview = true;
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
        $this->responseData->thumbnailImage($this->COLUMNS, $this->ROWS, true);
        
        $this->_fileType = "pdfimage";      
    }  

    public function getOutFileName(){
        return $this->output_filename;
    }

    public function getFileType(){
        return $this->_fileType;
    }
    public function hasPreviewImage(){
        return $this->has_preview;
    } 
     public function hasTempFile(){
        return $this->has_temp_file;
    }   
    
}