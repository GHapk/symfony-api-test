<?php
declare(strict_types=1);
namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Kunde;
use App\Entity\Public\FederalState;
use App\Entity\Sec\User;
use App\Entity\Std\Address;
use App\Entity\Std\Broker;
use App\Entity\Std\Customer;
use App\Entity\Std\CustomerAddress;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\SecurityBundle\Security;

final class CustomerKundeProcessor implements ProcessorInterface
{
    public function __construct(private EntityManager $entityManager, private Security $security) {}

    /**
     * @param Kunde $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     *
     * @return void
     *
     * @throws ORMException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data->getId() !== null) {
            $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(['id' => $data->getId()]);
            if (null === $customer) {
                throw new \RuntimeException('customer not found');
            }
            $user = $customer->getUser();
            if (null === $user) {
                $user = (new User());
            }
        } else {
            $customer = new Customer();
            $user = (new User())
                ->setBroker(
                    $this->security->getUser()->getBroker()
                );
        }
        $customer
            ->setLastName($data->getName())
            ->setFirstName($data->getVorname())
            ->setCompany($data->getFirma())
            ->setBirthday($data->getGeburtsdatum())
            ->setGender($data->getGeschlecht())
            ->setEmail($data->getEmail());
        $user
            ->setEmail($data->getUser()->getUserName())
            ->setCustomer($customer)
            ->setActive($data->getUser()->getActive() === 1);

        if ($data->getUser()->getPasswort() !== null) {
            $user->setPassword($data->getUser()->getPasswort());
        }
        $customer->setUser($user);

        foreach ($data->getAdressen() as $adresse) {
            $existing = true;
            $customerAddress = $customer->getCustomerAddressByAddressIdAndCustomerId(
                $adresse->getAdresseId(),
                $customer->getId()
            );
            if (null === $customerAddress) {
                $customerAddress = (new CustomerAddress())
                    ->setCustomer($customer)
                    ->setAddress(new Address());
                $existing = false;
            }
            $customerAddress->getAddress()
                ->setId($adresse->getAdresseId())
                ->setStreet($adresse->getStasse())
                ->setZip($adresse->getPlz())
                ->setCity($adresse->getOrt())
                ->setFederalState(
                    $this->entityManager->getReference(FederalState::class, $adresse->getBundesland())
                );
            $customerAddress
                ->setDeleted(false)
                ->setCommercial($adresse->getDetails()->isGeschaeftlich())
                ->setBillingAddress($adresse->getDetails()->isRechnungsadresse());

            if (!$existing) {
                $customer->getCustomerAddresses()->add($customerAddress);
            }
        }

    }
}