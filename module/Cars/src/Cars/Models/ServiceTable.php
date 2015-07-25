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
    function add(ServiceHistory $serviceHistory){
                
        $this->em->beginTransaction();
        $this->em->persist($serviceHistory);
        $this->em->flush($serviceHistory);
        $this->em->commit();
    }
    
    function retrieveHistorySingleCar(IntegerType $id){
        
        $query = $this->em->createQuery('SELECT sh.Rid, sh.Date, sh.CarId, sh.Cost, sh.Comments, sh.InvoiceNumber, sh.Odometer, s.SupplierId, s.Name  FROM  ServiceHistory sh INNER JOIN Suppliers s ON sh.SupplierId = s.SupplierId  WHERE sh.CarId = :car');
        $query->setParameter('car', $id);
        $serviceHistory = $query->getResult();
        return $serviceHistory;
    }
}

?>