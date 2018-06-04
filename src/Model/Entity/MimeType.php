<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MimeType Entity
 *
 * @property int $id
 * @property string $mime_type
 * @property string $ext
 * @property int $ambiguous
 */
class MimeType extends Entity
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
        'mime_type' => true,
        'ext' => true,
        'ambiguous' => true
    ];
}
