<?php
namespace Cars\Models;

use Doctrine\ORM\EntityManager;
use Cars\Entity\ServiceHistory;
use Doctrine\DBAL\Types\IntegerType;

class ServiceTable
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    function __destruct()
    {
        $this->em->close();
    }

    /**
     * Persist to the database
     *
     * @param ServiceHistory $serviceHistory            
     */
    function add(ServiceHistory $serviceHistory)
    {
        $this->em->beginTransaction();
        $this->em->persist($serviceHistory);
        $this->em->flush($serviceHistory);
        $this->em->commit();
    }

    function retrieveHistorySingleCar($id)
    {
        $query = $this->em->createQuery('SELECT sh.rid, sh.date, sh.carid, sh.comments, sh.odometer, s.name, sh.cost
            FROM  Cars\Entity\ServiceHistory sh JOIN sh.suppliers s
            WHERE sh.carid = :car');
        $query->setParameter('car', $id, IntegerType::INTEGER);
        $serviceHistory = $query->getResult();
        return $serviceHistory;
    }
}

?>