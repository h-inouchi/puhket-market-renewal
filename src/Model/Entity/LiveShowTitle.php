<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LiveShowTitle Entity
 *
 * @property int $id
 * @property string $title
 * @property string $detail
 * @property string $open
 * @property string $start
 * @property string $fee
 * @property string $iri
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ComedyLiveShow[] $comedy_live_shows
 * @property \App\Model\Entity\IkuyoComment[] $ikuyo_comments
 * @property \App\Model\Entity\PersonalSchedule[] $personal_schedules
 */
class LiveShowTitle extends Entity
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
