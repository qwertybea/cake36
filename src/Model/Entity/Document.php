<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\Translate\TranslateTrait;
/**
 * Document Entity
 *
 * @property int $id
 * @property int $type_id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $other_details
 * @property string $document_cover
 * @property bool $published
 * @property bool $deleted
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\DocumentType $document_type
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Interaction[] $interactions
 */
class Document extends Entity
{

    use TranslateTrait;
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
        'type_id' => true,
        'user_id' => true,
        'document_cover' => true,
        'country_id' => true,
        'region_id' => true,
        'name' => true,
        'description' => true,
        'other_details' => true,
        'published' => true,
        'deleted' => true,
        'created' => true,
        'modified' => true,
        'document_type' => true,
        'user' => true,
        'file' => true,
        'interactions' => true,
        'text_document' => true,
        'country' => true,
        'region' => true,
    ];
}
