<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComedyLiveShow Entity
 *
 * @property int $id
 * @property string $live_show_date
 * @property int $live_show_title_id
 * @property int $place_id
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Place $place
 * @property \App\Model\Entity\LiveShowTitle $live_show_title
 */
class ComedyLiveShow extends Entity
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
        '*' => true,
        'id' => false
    ];
}
