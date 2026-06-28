<?php

namespace App\Repository;

use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Word>
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    //    /**
    //     * @return Word[] Returns an array of Word objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Word
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findRandom(): ?Word
    {
        $count = $this->count([]);

        if ($count === 0) {
            return null;
        }

        $randomOffset = random_int(0, $count - 1);

        return $this->createQueryBuilder('w')
            ->setFirstResult($randomOffset)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function existsByWord(string $word): bool
    {
        $result = $this->createQueryBuilder('w')
            ->select('COUNT(w.id)')
            ->where('w.word = :word')
            ->setParameter('word', strtoupper($word))
            ->getQuery()
            ->getSingleScalarResult();

        return $result > 0;
    }
}
