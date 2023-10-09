<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\Std\Customer;
use App\Provider\CustomerKundeProvider;
use App\Repository\std\CustomerRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetCustomerListController extends AbstractController
{
    public function __construct(private EntityManager $entityManager) {}

    public function __invoke(): iterable
    {
        $currentUser = $this->getUser();
        if ($currentUser === null) {
            return [];
        }
        /** @var CustomerRepository $repo */
        $repo = $this->entityManager->getRepository(Customer::class);

        $result = $repo->fetchAllActiveForBrokerId($currentUser->getBroker()->getId());

        $kunden = [];
        foreach ($result as $customer) {
            $kunden[] = CustomerKundeProvider::customerToKunde($customer);
        }

        return $kunden;
    }

}