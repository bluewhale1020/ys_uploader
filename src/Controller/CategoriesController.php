<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
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
            
            //カテゴリ名
            if(!empty($this->request->data['カテゴリ名'])){
                $conditions[] = ['id' => $this->request->data['カテゴリ名']]; 
                $noData = false;               
            }
            
            //規定値
            if(!empty($this->request->data['規定値'])){
               if($this->request->data['規定値'] == 1){
                   $conditions[] = ['is_default'=>$this->request->data['規定値']];
                   
               }else{
                   $conditions[] = ["or"=>['is_default IS NULL','is_default'=>0] ];
               }
                
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
        //debug($conditions);die();
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
        
        $categoryArray = $this->Categories->find("list");
        $this->set(compact('categoryArray'));        
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['FileUploads']
        ]);

        $this->set('category', $category);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('カテゴリを新規に登録しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('カテゴリの新規登録に失敗しました。再度やり直してください。'));
        }
        $this->set(compact('category'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('カテゴリを更新しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('カテゴリの更新に失敗しました。再度やり直してください。'));
        }
        $this->set(compact('category'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('指定のカテゴリを削除しました。'));
        } else {
            $this->Flash->error(__('指定のカテゴリ削除に失敗しました。再度やり直してください。'.$this->Categories->error));
        }

        return $this->redirect(['action' => 'index']);
    }
}
