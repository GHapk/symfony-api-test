<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\Std\Address;
use App\Provider\AddressEntityAdresseDtoProvider;
use App\Repository\std\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetAddressListContoller extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function __invoke(): iterable
    {
        $currentUser = $this->getUser();
        if ($currentUser === null) {
            return [];
        }
        /** @var AddressRepository  $repo */
        $repo = $this->entityManager->getRepository(Address::class);

        $result = $repo->fetchAllActiveForBrokerId($currentUser->getBroker()->getId());

        $adressen = [];
        foreach ($result as $address) {
            $adressen[] = AddressEntityAdresseDtoProvider::addressEntityToDto($address, $currentUser->getBroker()->getId());
        }

        return $adressen;
    }
}