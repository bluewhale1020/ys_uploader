<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \App\Model\Table\FileUploadsTable|\Cake\ORM\Association\HasMany $FileUploads
 *
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTable extends Table
{
    protected $_defaultCategoryId;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('FileUploads', [
            'foreignKey' => 'category_id'
        ]);
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
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');
        $validator
            ->boolean('is_default')
            ->allowEmpty('is_default');
            
        return $validator;
    }
    
    public function getDefaultCategoryId(){
        
        $query = $this->find()
        ->where(['is_default'=> true])->first();
        
        return $query->id;
    }
    
    /*
     * getCategoryMenuData method
     * 再度メニュー用のカテゴリデータを取得
     * 
     */
    
    public function getCategoryMenuData(){
        $this->_defaultCategoryId = $this->getDefaultCategoryId();
      
        $this->FileUploads = TableRegistry::get("FileUploads");
        $categoryData = $this->find()->all();       
        $result = $this->find()
            ->map(function ($oneCategory) {
                if($oneCategory->id == $this->_defaultCategoryId){
                    $oneCategory->count = $this->FileUploads->find()->where(['or'=>['category_id'=>$oneCategory->id,'category_id IS NULL'] ])->count();
                }else{
                    $oneCategory->count = $this->FileUploads->find()->where(["category_id"=>$oneCategory->id])->count();
                }
                
                return $oneCategory;
            }); 
      
        
        return $result;
        
    }
 
     /*
     * beforeDelete method
     * カテゴリにアップロードファイルがある場合は、削除不可
     * 
     */
    public function beforeDelete($event, $entity, $options)
    {
        $this->FileUploads = TableRegistry::get("FileUploads");
        $count = $this->FileUploads->find()->where(['category_id'=>$entity->id])->count();
        
        if($count > 0){
            $this->error = __('指定のカテゴリにアップロードファイルがあるため、削除できません。');
             return false;
            
        }
    }
 
     /*
     * afterSave method
     * 保存するレコードが規定値の場合、他のレコードを非規定値に設定
     * 
     */
    public function afterSave($event, $entity, $options) {

         $query = $this->find()
        ->where(['is_default'=> 1,'not'=>['id'=>$entity->id] ])->first(); 
        if($entity->is_default == 1) {

            if($query){//他のレコードを非規定値に設定
                $query->set('is_default', null);
                $this->save($query);
            }          
            
        }else{
            if(!$query){//最初のレコードを規定値に設定
                 $query = $this->find()
                ->where(['not'=>['id'=>$entity->id] ])->first();             
                $query->set('is_default', 1);
                $this->save($query);
            }             
        }
    }
    
   
}
