<?php
declare(strict_types=1);
namespace App\Processor;

use ApiPlatform\Exception\InvalidArgumentException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\AdresseWrite;
use App\Entity\Public\FederalState;
use App\Entity\Std\Address;
use App\Entity\Std\Customer;
use App\Entity\Std\CustomerAddress;
use Doctrine\ORM\EntityManager;

class AdresseDtoAddressEntiyProcessor implements ProcessorInterface
{

    public function __construct(private EntityManager $entityManager) {}

    /**
     * @param AdresseWrite $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     *
     * @throws \Doctrine\ORM\Exception\NotSupported
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (isset($uriVariables['id'])) {
            $address = $this->entityManager->getRepository(Address::class)->findOneBy(
                ['id' => $uriVariables['id']]
            );
            if (null === $address) {
                throw new \InvalidArgumentException('address not found');
            }
        } else {
            $address = (new Address());
            $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(
                ['id' => $data->getDetails()?->getKundenId()]
            );
            if (null === $customer) {
                throw new InvalidArgumentException('customer for address not found');
            }
            $customerAddress = (new CustomerAddress())
                ->setAddress($address)
                ->setCustomer($customer)
                ->setBillingAddress($data->getDetails()?->isRechnungsadresse())
                ->setCommercial($data->getDetails()?->isGeschaeftlich());
            $this->entityManager->persist($customerAddress);
        }
        $address
            ->setZip($data->getPlz())
            ->setCity($data->getOrt())
            ->setStreet($data->getStasse())
            ->setFederalState($this->entityManager->getReference(FederalState::class, $data->getBundesland()));
        $this->entityManager->persist($address);
        $this->entityManager->flush();
    }
}