<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\Std\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

#[AsController]
class DeleteAddressController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function __invoke(Address $address): void {
        $currentUser = $this->getUser();
        if ($currentUser === null) {
            throw new AuthenticationException('not logged in');
        }

        $foundMatch = false;
        foreach ($address->getCustomerAddresses() as $customerAddress) {
            if ($customerAddress->getCustomer()->getBroker()->getId() === $currentUser->getBroker()->getId()) {
                $foundMatch = true;
                $customerAddress->setDeleted(1);
            }
        }
        if ($foundMatch) {
            $this->entityManager->remove($address);
        }

        $this->entityManager->flush();;
    }

}