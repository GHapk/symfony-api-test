<?php
declare(strict_types=1);
namespace App\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\KundeRead;
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
     * @return KundeRead|KundeRead[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): KundeRead|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $kunden = [];
            $customers = $this->collectionProvider->provide($operation, $uriVariables, $context);
            foreach ($customers as $customer) {
                $kunden[] = self::customerToKunde($customer);
            }

            return $kunden;
        }

        $customer = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($customer !== null) {
            return self::customerToKunde($customer);
        }

        return null;
    }

    public static function customerToKunde(Customer $customer): KundeRead {
        $kunde = (new KundeRead())
            ->setGeloescht($customer->isDeleted())
            ->setId($customer->getId())
            ->setName($customer->getLastName())
            ->setVorname($customer->getFirstName())
            ->setGeburtsdatum($customer->getBirthday())
            ->setGeschlecht($customer->getGender())
            ->setEmail($customer->getEmail())
            ->setVermittlerId($customer->getBroker()?->getId());

        $adressen = [];

        foreach ($customer->getCustomerAddresses() as $customerAddress) {
            $adressen[] = CustomerAddressAdresseProvider::customerAddressToAdresse($customerAddress);
        }
        $kunde->setAdressen($adressen);
        if ($customer->getUser() !== null) {
            $kunde->setUser(
                UserEntityUserDtoProvider::userEntityToDto($customer->getUser())
            );
        }

        return $kunde;
    }
}