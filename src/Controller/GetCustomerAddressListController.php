<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\Std\CustomerAddress;
use App\Provider\CustomerAddressAdresseProvider;
use App\Repository\std\CustomerAddressRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetCustomerAddressListController extends AbstractController
{
    public function __construct(private EntityManager $entityManager) {}

    public function __invoke(): iterable
    {
        $currentUser = $this->getUser();
        if ($currentUser === null) {
            return [];
        }
        /** @var CustomerAddressRepository $repo */
        $repo = $this->entityManager->getRepository(CustomerAddress::class);

        $result = $repo->fetchAllActiveForBrokerId($currentUser->getBroker()->getId());

        $kunden = [];
        foreach ($result as $customer) {
            $kunden[] = CustomerAddressAdresseProvider::customerAddressToAdresse($customer);
        }

        return $kunden;
    }

}