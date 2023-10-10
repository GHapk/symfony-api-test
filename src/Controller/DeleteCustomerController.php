<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\Std\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

#[AsController]
class DeleteCustomerController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function __invoke(Customer $customer): void {
        $currentUser = $this->getUser();
        if ($currentUser === null) {
            throw new AuthenticationException('not logged in');
        }

        if ($customer->getBroker()->getId() !== $currentUser->getBroker()->getId()) {
            throw new AuthenticationException('Not allowed');
        }

        $customer->setDeleted(1);

        $this->entityManager->flush();;
    }

}