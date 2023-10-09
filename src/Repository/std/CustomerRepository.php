<?php
declare(strict_types=1);
namespace App\Repository\std;

use App\Entity\Std\Broker;
use App\Entity\Std\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CustomerRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @param int $brokerId
     *
     * @return iterable|Customer[]
     *
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function fetchAllActiveForBrokerId(int $brokerId): iterable {
        return $this->findBy([
            'broker' => $this->getEntityManager()->getReference(Broker::class, $brokerId),
            'deleted' => 0
        ]);
    }

}