<?php
declare(strict_types=1);
namespace App\Doctrine\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Very primitive class to handle soft delete flag. just related to an interface that must be implemented and no
 * configuration for relevant column
 */
class SoftDeletableFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {

        if ($targetEntity->reflClass->implementsInterface(SoftDeletableInterface::class)) {
            return 'CAST (' . $targetTableAlias . '.geloescht AS int)=0';
        }

        return '';
    }
}