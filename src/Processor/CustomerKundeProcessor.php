<?php
declare(strict_types=1);
namespace App\Processor;

use ApiPlatform\Exception\InvalidArgumentException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Kunde;
use App\Entity\Std\Customer;
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
        if (isset($uriVariables['id'])) {
            $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(
                ['id' => $uriVariables['id']]
            );
            if (null === $customer) {
                throw new InvalidArgumentException('customer not found');
            }
        } else {
            $customer = new Customer();
        }
        $customer
            ->setLastName($data->getName())
            ->setFirstName($data->getVorname())
            ->setCompany($data->getFirma())
            ->setBirthday($data->getGeburtsdatum())
            ->setGender($data->getGeschlecht())
            ->setEmail($data->getEmail());
       $this->entityManager->persist($customer);
       $this->entityManager->flush();
    }
}