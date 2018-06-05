<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * FileUpload Entity
 *
 * @property int $id
 * @property string $file_name
 * @property string $mime_type
 * @property string $file_size
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $user_id 
 */
class FileUpload extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'file_name' => true,
        'hash_name'=>true,
        'password' => true,        
        'mime_type' => true,
        'file_size' => true,
        'created' => true,
        'modified' => true,
        'description' => true,
        'user_id'=>true,
        'category_id' => true
    ];
    
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }        
        //return (new DefaultPasswordHasher)->hash($password);
    }    
    
}
