<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MimeTypes Model
 *
 * @method \App\Model\Entity\MimeType get($primaryKey, $options = [])
 * @method \App\Model\Entity\MimeType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MimeType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MimeType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MimeType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MimeType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MimeType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MimeType findOrCreate($search, callable $callback = null, $options = [])
 */
class MimeTypesTable extends Table
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

        $this->setTable('mime_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('mime_type')
            ->maxLength('mime_type', 80)
            ->requirePresence('mime_type', 'create')
            ->notEmpty('mime_type');

        $validator
            ->scalar('ext')
            ->maxLength('ext', 10)
            ->allowEmpty('ext');

        $validator
            ->allowEmpty('ambiguous');

        return $validator;
    }
    
    /**
     * method getAllExt
     *
     * @param null
     * @return $query array
     */
    public function getAllExt()
    {
        // コントローラーやテーブルのメソッド内で
        $query = $this->find('all', [
            'fields' => 'ext'
        ])
        ->where(['ambiguous != 1'])
        ;       
        foreach ($query as $record) {
            $resultArray[$record->ext] = $record->ext;
        }
       
        return $resultArray;
    }      
    /**
     * method createAllowedMimeTable
     *
     * @param null
     * @return $query array
     */
    public function createAllowedMimeArray()
    {
        // コントローラーやテーブルのメソッド内で
        $query = $this->find('list', [
            'keyField' => 'mime_type',
            'valueField' => 'ext',
            //'groupField' => 'author_id'
        ])
        ->where(['MimeTypes.ambiguous != 1'])
        ;       
    
       
        return $query->toArray();
    }    
    /**
     * method createAllowedMimeTable
     *
     * @param null
     * @return $query array
     */
    public function createAllowedAmbiguousMimeArray()
    {
        // コントローラーやテーブルのメソッド内で
        $query = $this->find('all', [
            'fields' => 'mime_type',
            //'valueField' => 'ext',
            //'groupField' => 'author_id'
        ])
        ->where(['MimeTypes.ambiguous = 1'])
        ;       
        foreach ($query as $record) {
            $resultArray[] = $record->mime_type;
        }
       
        return $resultArray;
    }     
    
    
}
