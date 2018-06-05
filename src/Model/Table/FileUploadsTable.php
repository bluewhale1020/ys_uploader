<?php
namespace App\Model\Table;

use App\Model\Table\AppTable;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

/**
 * FileUploads Model
 *
 * @method \App\Model\Entity\FileUpload get($primaryKey, $options = [])
 * @method \App\Model\Entity\FileUpload newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FileUpload[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FileUpload|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FileUpload|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FileUpload patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FileUpload[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FileUpload findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FileUploadsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('file_uploads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users');
        $this->belongsTo('Categories');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('file_name')
            ->maxLength('file_name', 50)
            ->requirePresence('file_name', 'create')
            ->notEmpty('file_name');
        $validator
            ->scalar('hash_name')
            ->maxLength('hash_name', 50)
            ->requirePresence('hash_name', 'create')
            ->notEmpty('hash_name');            
        $validator
            ->maxLength('password', 255)
            ->allowEmpty('password', 'create');

        $validator
            ->scalar('mime_type')
            ->maxLength('mime_type', 80)
            ->requirePresence('mime_type', 'create')
            ->notEmpty('mime_type');

        $validator
            ->scalar('file_size')
            ->maxLength('file_size', 50)
            ->requirePresence('file_size', 'create')
            ->notEmpty('file_size');
        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->notEmpty('description');
        $validator
            ->integer('category_id')
            ->allowEmpty('category_id', 'create');

        return $validator;
    }
    
    public function checkPassGet($id,$input_pass)
    {
        $fileUpload = $this->get($id);
        if(empty($fileUpload->password)){
            return $fileUpload;
        }
        
        $result = (new DefaultPasswordHasher)->check($input_pass, $fileUpload->password);
        //debug($result . " \n");debug($fileUpload->password);die();
        if($result){//パスワードが一致
            return $fileUpload;
        }
        
        
        return false;
    }
    
    private function passToHash($pass){
        
        return md5($pass);
    }    
}
