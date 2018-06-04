<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MimeTypes Controller
 *
 * @property \App\Model\Table\MimeTypesTable $MimeTypes
 *
 * @method \App\Model\Entity\MimeType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MimeTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->request->is('post')){
            //データを検索する
            $conditions = [];
            $noData = true;
            
            //Mime Type名
            if(!empty($this->request->data['MimeType名'])){
                $conditions[] = ['mime_type like' => "%" . $this->request->data['MimeType名'] ."%"]; 
                $noData = false;               
            }
            
            //拡張子
            if(!empty($this->request->data['拡張子'])){
               
                $conditions[] = ['ext'=>$this->request->data['拡張子']];
                   //debug($conditions);die();
                $noData = false;                                
            }            
            
            if(!$noData){
                //debug($conditions);
                    $this->paginate = [
                        'conditions' => $conditions
                    ];
                
            
            }

        } 

        $mimeTypes = $this->paginate($this->MimeTypes);

        $this->set(compact('mimeTypes'));

        $extArray = $this->MimeTypes->getAllExt();
        $this->set(compact('extArray'));
    }

    /**
     * View method
     *
     * @param string|null $id Mime Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mimeType = $this->MimeTypes->get($id, [
            'contain' => []
        ]);

        $this->set('mimeType', $mimeType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mimeType = $this->MimeTypes->newEntity();
        if ($this->request->is('post')) {
            $mimeType = $this->MimeTypes->patchEntity($mimeType, $this->request->getData());
            if ($this->MimeTypes->save($mimeType)) {
                $this->Flash->success(__('新規MimeType登録を完了しました'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('MimeType登録に失敗しました。再度やり直してください。'));
        }
        $this->set(compact('mimeType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mime Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mimeType = $this->MimeTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mimeType = $this->MimeTypes->patchEntity($mimeType, $this->request->getData());
            if ($this->MimeTypes->save($mimeType)) {
                $this->Flash->success(__('MimeType情報を更新しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('MimeType情報の更新に失敗しました。再度やり直してください。'));
        }
        $this->set(compact('mimeType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mime Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mimeType = $this->MimeTypes->get($id);
        if ($this->MimeTypes->delete($mimeType)) {
            $this->Flash->success(__('指定のMimeTypeを削除しました。'));
        } else {
            $this->Flash->error(__('MimeTypeの削除に失敗しました。再度やり直してください。'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
