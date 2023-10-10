<?php

namespace App\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Adresse;
use App\Dto\AdressenDetails;
use App\Entity\Std\CustomerAddress;

class CustomerAddressAdresseProvider implements ProviderInterface
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
     * @return Adresse|Adresse[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Adresse|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $adressen = [];
            $customerAddresses = $this->collectionProvider->provide($operation, $uriVariables, $context);
            foreach ($customerAddresses as $customerAddress) {
                $adressen[] = self::customerAddressToAdresse($customerAddress);
            }

            return $adressen;
        }

        $customerAddress = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($customerAddress !== null) {
            return self::customerAddressToAdresse($customerAddress);
        }

        return null;
    }

    public static function customerAddressToAdresse(CustomerAddress $customerAddress): Adresse {
        $adresse = AddressEntityAdresseDtoProvider::addressEntityToDto(
            $customerAddress->getAddress(),
            $customerAddress->getCustomer()->getBroker()->getId()
        );
        $adressenDetails = (new AdressenDetails())
            ->setRechnungsadresse($customerAddress->isBillingAddress())
            ->setGeschaeftlich($customerAddress->isCommercial());
        $adresse->setDetails($adressenDetails);

        return $adresse;
    }
}