<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

use Cake\ORM\TableRegistry;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');


        $this->loadComponent('Auth', [
            'authorize' => [
            'Controller'
                //'Acl.Actions' => ['actionPath' => 'controllers/']
            ],
            'loginAction' => [
                'plugin' => false,
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'plugin' => false,
                'controller' => 'FileUploads',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'plugin' => false,
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => false
            ],
            'authError' => 'You are not authorized to access that location.',
            'flash' => [
                'element' => 'error'
            ]
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }


        public function isAuthorized($user) {
            // Admin can access every action
            if (isset($user['role']) && in_array($user['role'], array('admin')) ) {
                return true;
            }
            else  if (isset($user['role']) && $user['role'] === 'user') {
                if (!in_array($this->action, array('admin_index','admin_view','admin_add','admin_edit','admin_delete'))) {
                    return true;
                }
            }
        
            // デフォルトは拒否
            return false;
        }

        public function beforeRender(Event $event)
        {
            $this->viewBuilder()->setTheme('AdminLTE');
        
            // For CakePHP before 3.5
            //$this->viewBuilder()->theme('AdminLTE');
        }
                
        public function beforeFilter(Event $event){
            //$this->Auth->flash['params']['class'] = 'alert alert-danger'; 
            //$this->Auth->allow(['index', 'view', 'display']);
                $this->set('authUser', $this->Auth->user());
                
                //メインメニューにカテゴリ一覧を並べる
                $this->Categories = TableRegistry::get("Categories");
                $this->set('categoryData', $this->Categories->getCategoryMenuData());
                
                    
        }

}
