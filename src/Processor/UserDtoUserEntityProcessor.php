<?php
declare(strict_types=1);
namespace App\Processor;

use ApiPlatform\Exception\InvalidArgumentException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\UserWrite;
use App\Entity\Sec\User;
use App\Entity\Std\Customer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;

final class UserDtoUserEntityProcessor implements ProcessorInterface
{
    public function __construct(private EntityManager $entityManager) {}

    /**
     * @param UserWrite $data
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
            $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(
                ['id' => $uriVariables['id']]
            );
            if (null === $userEntity) {
                throw new InvalidArgumentException('user not found');
            }
        } else {
            $userEntity = new User();

            if ($data->getPasswort() === null) {
                throw new InvalidArgumentException('password must be set');
            }
            if ($data->getUserName() === null) {
                throw new InvalidArgumentException('username must be set');
            }
        }

        if ($data->getCustomerId() === null && !isset($uriVariables['id'])) {
            throw new InvalidArgumentException('customerId must be set');
        } else {
            $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(
                ['id' => $data->getCustomerId()]
            );
            if (null === $customer) {
                throw new InvalidArgumentException('customerId not found');
            } elseif (
                $customer->getUser() !== null
                && (
                    !isset($uriVariables['id']) ||
                    $customer->getUser()->getId() !== $userEntity->getId()
                )
            ) {
                throw new InvalidArgumentException('customer already has an user. try to edit');
            }
            $userEntity->setCustomer($customer);
        }

        $userEntity->setActive($data->getActive());
        if ($data->getPasswort()) {
            $userEntity->setPassword($data->getPasswort());
        }
        if ($data->getUserName()) {
            $userEntity->setEmail($data->getUserName());
        }

        $this->entityManager->persist($userEntity);
       $this->entityManager->flush();
    }
}