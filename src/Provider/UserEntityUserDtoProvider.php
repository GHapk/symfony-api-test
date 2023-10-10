<?php
declare(strict_types=1);
namespace App\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\User as UserDto;
use App\Dto\UserRead;
use App\Entity\Sec\User as UserEntity;

class UserEntityUserDtoProvider implements ProviderInterface
{
    public function __construct(
        private ProviderInterface $itemProvider,
        private ProviderInterface $collectionProvider
    ){}

    /**
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     *
     * @return UserRead|UserRead[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): UserDto|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $userDtos = [];
            $userEntities = $this->collectionProvider->provide($operation, $uriVariables, $context);
            foreach ($userEntities as $userEntity) {
                $userDtos[] = self::userEntityToDto($userEntity);
            }

            return $userDtos;
        }

        $userEntity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($userEntity !== null) {
            return self::userEntityToDto($userEntity);
        }

        return null;
    }

    public static function userEntityToDto(UserEntity $userEntity): UserRead {
       return (new UserRead())
                ->setUserName($userEntity->getEmail())
                ->setActive($userEntity->isActive() ? 1 : 0)
                ->setLastLogin($userEntity->getLastLogin());
    }
}