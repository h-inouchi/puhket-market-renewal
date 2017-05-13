<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IkuyoComment Entity
 *
 * @property int $id
 * @property int $comedy_live_show_id
 * @property int $live_show_title_id
 * @property string $nick_name
 * @property int $ticket_count
 * @property string $comment
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\ComedyLiveShow $comedy_live_show
 * @property \App\Model\Entity\LiveShowTitle $live_show_title
 */
class IkuyoComment extends Entity
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
