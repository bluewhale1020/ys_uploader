<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

	public function initialize()
	{
		parent::initialize();

		// Allow full access to this controller
		// $this->Auth->allow();
	}

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('signup');
    }

    /**
     * Signup method
     *
     * @return void Redirects on successful signup, renders view otherwise.
     */
    public function signup()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('サインアップを実行しました。'));
                $this->Auth->setUser($user->toArray());
                return $this->redirect($this->Auth->redirectUrl());
                //return $this->redirect( '/' );
            } else {
                $this->Flash->error(__('サインアップに失敗しました。再度やり直してください。'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        $this->viewBuilder()->layout('register');
    }

    /**
     * Login method
     *
     * @return void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(
                    __('Email or password is incorrect'),
                    'default',
                    [],
                    'auth'
                );
            }
        }
        $this->viewBuilder()->layout('login');
    }

    /**
     * Logout method
     *
     * @return void Redirects
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if($this->request->is('post')){
            //データを検索する
            $conditions = [];
            $noData = true;
            
            //ファイル名
            if(!empty($this->request->data['ユーザー名'])){
                $conditions[] = ['username like' => "%" . $this->request->data['ユーザー名'] ."%"]; 
                $noData = false;               
            }
          
            
            if(!$noData){
                //debug($conditions);
                    $this->paginate = [
                        'conditions' => $conditions
                    ];
                
            
            }

        }        
        
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$user = $this->Users->get($id);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('新規ユーザー登録を完了しました。'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('ユーザー登録に失敗しました。再度やり直してください。'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        
        if($this->Auth->user('role') != 'admin' and $this->Auth->user('id') != $id){
            throw new UnauthorizedException('このユーザーを編集する権限がありません。');
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザー情報を更新しました。'));
                if($this->Auth->user('id') == $id){//自分の編集ならば、認証情報更新
                    $this->Auth->setUser($user->toArray());
                }                
                return $this->redirect(['action' => 'view',$user->id]);
            } else {
                $this->Flash->error(__('ユーザー情報の更新に失敗しました。再度やり直してください。'));
            }
        }

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if($this->Auth->user('role') != 'admin' and $this->Auth->user('id') != $id){
            throw new UnauthorizedException('このユーザーを削除する権限がありません。');
        }        
        
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('指定のユーザーを削除しました。'));
        } else {
            $this->Flash->error(__('ユーザーの削除に失敗しました。再度やり直してください。'));
        }
        if($this->Auth->user('id') == $id){
            return $this->redirect(['action' => 'logout']);
        }
        return $this->redirect(['action' => 'index']);
    }
}
