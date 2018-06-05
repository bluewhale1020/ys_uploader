<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;

/**
 * FileUploads Controller
 *
 * @property \App\Model\Table\FileUploadsTable $FileUploads
 *
 * @method \App\Model\Entity\FileUpload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FileUploadsController extends AppController
{

    public $paginate = [
        'limit' => 25,
        'contain'=>['Users',"Categories"],
        'order' => [
            'FileUploads.created' => 'desc'
        ]
    ];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('FileHandler');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Image');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($category_id = null)
    {

        //default値ID取得
        $category_default_id = $this->Categories->getDefaultCategoryId();
        if(empty($category_id)){
            $category_id = $category_default_id;
        }
        if($category_id == $category_default_id){
            $conditions = ['or'=>['category_id'=>$category_id,'category_id IS NULL'] ];
        }else{
            $conditions = ['category_id'=>$category_id];
        }
    
        if($this->request->is('post')){
            
     
            //データを検索する
            //$conditions = [];
            //$noData = true;
            
            //ファイル名
            if(!empty($this->request->data['ファイル名'])){
                $conditions[] = ['file_name like' => "%" . $this->request->data['ファイル名'] ."%"]; 
               // $noData = false;               
            }
            
            //ファイル種類
            if(!empty($this->request->data['ファイル種類'])){
                $mimeTypes = $this->FileHandler->getFullMimeTypesFromExt($this->request->data['ファイル種類']);
                
                $conditions[] = ['mime_type IN ('. $mimeTypes .')'];
               // $noData = false;                                
            }            
            //アップロード者
            if(!empty($this->request->data['アップロード者'])){
   
                $conditions[] = ['user_id'=>$this->request->data['アップロード者']];
                $noData = false;                                
            } 

            
            //if(!$noData){
                //debug($conditions);
          
            
            //}
        
            
            
        }
        $this->paginate['conditions'] =$conditions;       
        
        $fileUploads = $this->paginate($this->FileUploads);

        $this->set(compact('fileUploads'));
        
        $mimetypes = $this->FileHandler->getAllowedMime();
        $this->set(compact('mimetypes'));
        
        $Users = TableRegistry::get('Users');
        $users = $Users->find('list');
        $this->set(compact('users'));  
        
        $this->set(compact('category_id'));      
    }

    /**
     * View method
     *
     * @param string|null $id File Upload id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fileUpload = $this->FileUploads->get($id, [
            'contain' => ["Users","Categories"]
        ]);
        $imagedata = $this->Image->getImageData($fileUpload);
        if($imagedata){
            $this->set('imagedata', $imagedata);
        }
        
        $this->set('fileUpload', $fileUpload);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fileUpload = $this->FileUploads->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // 下記のログ出力処理を追記
            //$this->log($this->request->data['file_name'],LOG_DEBUG);
            
 
             // 下記の処理を追記します。
            $dir = realpath(TMP . DS . "uploads");
            $limitFileSize = 50 * 1000 * 1000;//50MB 1024 * 1024;
            try {
                $hash_name = $this->FileHandler->file_upload($this->request->data['file_name'], $dir, $limitFileSize);
            } catch (RuntimeException $e){
                $this->Flash->error(__('ファイルのアップロードができませんでした.'));
                $this->Flash->error(__($e->getMessage()));
                return $this->redirect(['action' => 'index']);
            }
 
            //ファイルデータの整理
            $this->request->data = $this->appendFileData($this->request->data,$hash_name);
            //debug($this->request->data);die();
            $fileUpload = $this->FileUploads->patchEntity($fileUpload, $this->request->getData());
             
 
            if ($this->FileUploads->save($fileUpload)) {
                $this->Flash->success(__('ファイルのアップロードを完了しました。'));

                return $this->redirect(['action' => 'view',$fileUpload->id]);
            }
            $this->Flash->error(__('ファイルデータの登録に失敗しました。 再度やり直してください。'));
        }
        $this->set(compact('fileUpload'));
        
        $categoryList = $this->Categories->find('list');
        $this->set(compact('categoryList'));         
    }

    /**
     * Add method
     *
     * @param requestdata 
     * @return modified requestdata
     */    
    private function appendFileData($requestdata,$hash_name){
        $file_name = $requestdata['file_name']['name'];
        $mime_type = $requestdata['file_name']['type'];
        $file_size = $requestdata['file_name']['size'];
        $requestdata['hash_name'] = $hash_name; 
        $requestdata['file_name'] = $file_name;        
        $requestdata['mime_type'] = $mime_type;
        $requestdata['file_size'] = $file_size;
        
        return $requestdata;
    }

    /**
     * Edit method
     *
     * @param string|null $id File Upload id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fileUpload = $this->FileUploads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fileUpload = $this->FileUploads->patchEntity($fileUpload, $this->request->getData());
            if ($this->FileUploads->save($fileUpload)) {
                $this->Flash->success(__('The file upload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file upload could not be saved. Please, try again.'));
        }
        $this->set(compact('fileUpload'));
    }


    /**
     * download method
     *
     * @param string|null $id File Upload id.
     * @return \Cake\Http\Response|file $response
     * @throws \Cake\Datasource\Exception\RuntimeException When file not found.
     */
    public function download($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
             if($this->Auth->user('role') == 'admin'){//adminはパス無しで削除できる
                 $fileUpload = $this->FileUploads->get($id);
             }else{
                $input_pass = $_POST['pass'];
                
                 $fileUpload = $this->FileUploads->checkPassGet($id,$input_pass);
                                  
                if(!$fileUpload){
                    $this->Flash->error(__('ファイルのパスワードが違います。'));
                    return $this->redirect(['action' => 'view',$id]);                
                }

             }   


            $dir = realpath(TMP . DS . "uploads");          
            try {
                //view無しで 出力
                $this->autoRender = false;
                $response = $this->FileHandler->file_download($fileUpload, $dir);
            } catch (RuntimeException $e){
                $this->Flash->error(__('ファイルのダウンロード出力ができませんでした.'));
                $this->Flash->error(__($e->getMessage()));
                return $this->redirect(['action' => 'view',$id]);
            }
            return $response;
        }
        
    }


    /**
     * Delete method
     *
     * @param string|null $id File Upload id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
 
         if($this->Auth->user('role') == 'admin'){//adminはパス無しで削除できる
             $fileUpload = $this->FileUploads->get($id);
         }else{
             $input_pass = $_POST['pass'];
             $fileUpload = $this->FileUploads->checkPassGet($id,$input_pass);                
         }        

        if(!$fileUpload){
            $this->Flash->error(__('ファイルのパスワードが違います。'));
            return $this->redirect(['action' => 'view',$id]);                
        }        
        //debug($fileUpload); die();
        //$fileUpload = $this->FileUploads->get($id);
        
        $dir = realpath(TMP . DS . "uploads");
        try {
            //$filename = $this->FileHandler->conv_sjis_auto($fileUpload->file_name);
            $del_file = new File($dir . DS . $fileUpload->hash_name);
            // ファイル削除処理実行
            if ($del_file->exists()) {
                // ファイルがある時の処理
                if($del_file->delete()) {
                    $fileUpload['file'] = "";
                } else {
                    throw new RuntimeException('ファイルの物理削除ができませんでした.');
                }
            }
            // else{
                // throw new RuntimeException('指定のファイルがありません。');
            // }           

        } catch (RuntimeException $e){
            $this->log($e->getMessage(),LOG_DEBUG);
            $this->Flash->error(__($e->getMessage()));
            $this->log($fileUpload->file_name,LOG_DEBUG);
            return $this->redirect(['action' => 'view',$id]);
        }        
        
        if ($this->FileUploads->delete($fileUpload)) {
            $this->Flash->success(__('指定したファイルを削除しました。'));
        } else {
            $this->Flash->error(__('指定したファイルを削除できませんでした。 再度やり直してください。'));
        }

        return $this->redirect(['action' => 'index',$fileUpload->category_id]);
    }
}
