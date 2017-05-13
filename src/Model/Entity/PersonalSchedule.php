<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PersonalSchedule Entity
 *
 * @property int $id
 * @property string $schedule_date
 * @property string $schedule_title
 * @property string $schedule_detail
 * @property string $start_time
 * @property string $end_time
 * @property int $live_show_title_id
 * @property int $place_id
 * @property int $user_id
 * @property int $unit_member_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\LiveShowTitle $live_show_title
 * @property \App\Model\Entity\Place $place
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\UnitMember $unit_member
 */
class PersonalSchedule extends Entity
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
