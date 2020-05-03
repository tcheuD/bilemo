<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllPaginate(int $page, int $limit=5): Paginator
    {
        $firstResult = ($page - 1) * $limit;

        $query = $this->createQueryBuilder('p')
            ->orderBy('p.name', 'DESC')
            ->setFirstResult($firstResult)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query);

        if ( $page !== 1 && ($paginator->count() <= $firstResult)) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.');
        }

        return $paginator;
    }
}
