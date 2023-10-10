<?php
declare(strict_types=1);
namespace App\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\AdresseRead;
use App\Entity\Std\Address as AddressEntity;
use App\Dto\Adresse as AdressDto;
use Symfony\Bundle\SecurityBundle\Security;

class AddressEntityAdresseDtoProvider implements ProviderInterface
{
    public function __construct(
        private ProviderInterface $itemProvider,
        private ProviderInterface $collectionProvider,
        private Security $security
    ){}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): AdressDto|array|null
    {
        $currentUser = $this->security?->getUser();
        if (null === $currentUser) {
            throw new \RuntimeException('not logged in');
        }
        if ($operation instanceof CollectionOperationInterface) {
            $adresseDtos = [];
            $addressEntities = $this->collectionProvider->provide($operation, $uriVariables, $context);
            foreach ($addressEntities as $addressEntity) {
                $adresseDtos[] = self::addressEntityToDto($addressEntity, $currentUser->getBroker()->getId());
            }

            return $adresseDtos;
        }

        $addressEntity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($addressEntity !== null) {
            return self::addressEntityToDto($addressEntity, $currentUser->getBroker()->getId());
        }

        return null;
    }

    public static function addressEntityToDto(AddressEntity $addressEntity, int $brokerId): AdressDto {
        return (new AdresseRead())
            ->setBrokerId($brokerId)
            ->setAdresseId($addressEntity->getId())
            ->setStasse($addressEntity->getStreet())
            ->setPlz($addressEntity->getZip())
            ->setOrt($addressEntity->getCity())
            ->setBundesland($addressEntity->getFederalState()->getShort());
    }
}