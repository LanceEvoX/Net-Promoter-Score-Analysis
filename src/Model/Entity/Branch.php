<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Branch Entity
 *
 * @property int $id
 * @property int|null $shortcode
 * @property string $name
 * @property int $b_category
 * @property string|null $b_prefix
 * @property int $hmn
 * @property string|null $address
 * @property \Cake\I18n\FrozenTime|null $trashed
 *
 * @property \App\Model\Entity\Feedback[] $feedback
 * @property \App\Model\Entity\Response[] $responses
 * @property \App\Model\Entity\UserBranch[] $user_branches
 */
class Branch extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'shortcode' => true,
        'name' => true,
        'b_category' => true,
        'b_prefix' => true,
        'hmn' => true,
        'address' => true,
        'trashed' => true,
        'feedback' => true,
        'responses' => true,
        'user_branches' => true,
    ];
}
