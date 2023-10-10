<?php
declare(strict_types=1);
namespace App\Repository\std;

use App\Entity\Std\Address;
use App\Entity\Std\Broker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @param int $brokerId
     *
     * @return iterable|Address[]
     *
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function fetchAllActiveForBrokerId(int $brokerId): iterable {

        $qb = $this->createQueryBuilder('a');
        $qb->join('a.customerAddresses', 'ca')
            ->join('ca.customer', 'c')
            ->where($qb->expr()->eq('c.broker', ':broker'))
            ->andWhere($qb->expr()->eq('ca.deleted', ':deleted'))
            ->setParameters([
                'broker' => $this->getEntityManager()->getReference(Broker::class, $brokerId),
                'deleted' => 0
            ]);

        return $qb->getQuery()->getResult();
    }
}