<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Interaction Entity
 *
 * @property int $document_id
 * @property int $user_id
 * @property int $interactiveMethod_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Document $document
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\InteractiveMethod $interactive_method
 */
class Interaction extends Entity
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
        'document_id' => true,
        'user_id' => true,
        'interactiveMethod_id' => true,
        'created' => true,
        'modified' => true,
        'document' => true,
        'user' => true,
        'interactiveMethod' => true
    ];
}
