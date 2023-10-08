<?php

namespace App\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Adresse;
use App\Dto\AdressenDetails;
use App\Dto\Kunde;
use App\Dto\User;
use App\Entity\Std\Customer;

class CustomerKundeProvider implements ProviderInterface
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
     * @return Kunde|Kunde[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Kunde|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $kunden = [];
            $customers = $this->collectionProvider->provide($operation, $uriVariables, $context);
            foreach ($customers as $customer) {
                $kunden[] = $this->customerToKunde($customer);
            }

            return $kunden;
        }

        $customer = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($customer !== null) {
            return $this->customerToKunde($customer);
        }

        return null;
    }

    private function customerToKunde(Customer $customer): Kunde {
        $kunde = (new Kunde())
            ->setId($customer->getId())
            ->setName($customer->getLastName())
            ->setVorname($customer->getFirstName())
            ->setGeburtsdatum($customer->getBirthday())
            ->setGeschlecht($customer->getGender())
            ->setEmail($customer->getEmail())
            ->setVermittlerId($customer->getBroker()?->getId());

        $adressen = [];

        foreach ($customer->getCustomerAddresses() as $customerAddress) {
            $adresse = (new Adresse())
                ->setAdresseId($customerAddress->getAddress()->getId())
                ->setStasse($customerAddress->getAddress()->getStreet())
                ->setPlz($customerAddress->getAddress()->getZip())
                ->setOrt($customerAddress->getAddress()->getCity())
                ->setBundesland($customerAddress->getAddress()->getFederalState()->getShort());
            $adressenDetails = (new AdressenDetails())
                ->setRechnungsadresse($customerAddress->isBillingAddress())
                ->setGeschaeftlich($customerAddress->isCommercial());
            $adresse->setDetails($adressenDetails);
            $adressen[] = $adresse;
        }
        $kunde->setAdressen($adressen);
        if ($customer->getUser() !== null) {
            $kunde->setUser(
                (new User())
                    ->setUserName($customer->getUser()->getEmail())
                    ->setActive($customer->getUser()->isActive() ? 1 : 0)
                    ->setLastLogin($customer->getUser()->getLastLogin())
            );
        }

        return $kunde;
    }
}