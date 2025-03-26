<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Response Entity
 *
 * @property int $id
 * @property int $form_id
 * @property int $branch_id
 * @property string|null $respondent_id
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property int|null $age
 * @property string|null $gender
 * @property string|null $location
 * @property \Cake\I18n\FrozenDate $visit_date
 * @property \Cake\I18n\Time $visit_time
 * @property int $status
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\Form $form
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Answer[] $answers
 * @property \App\Model\Entity\Feedback[] $feedback
 */
class Response extends Entity
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
        'form_id' => true,
        'branch_id' => true,
        'respondent_id' => true,
        'firstname' => true,
        'middlename' => true,
        'lastname' => true,
        'age' => true,
        'gender' => true,
        'location' => true,
        'visit_date' => true,
        'visit_time' => true,
        'status' => true,
        'created' => true,
        'form' => true,
        'branch' => true,
        'answers' => true,
        'feedback' => true,
    ];
}
