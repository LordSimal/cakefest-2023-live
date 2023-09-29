<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Repository Entity
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $forks
 * @property int $open_issues
 * @property int $external_ident
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Branch[] $branches
 */
class Repository extends Entity
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
        'name' => true,
        'url' => true,
        'forks' => true,
        'open_issues' => true,
        'external_ident' => true,
        'created' => true,
        'modified' => true,
        'branches' => true,
    ];
}
