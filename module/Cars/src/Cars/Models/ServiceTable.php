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
     * http://codesamplez.com/database/doctrine-relations-entity-tutorial assisted in this
     *
     * @param ServiceHistory $serviceHistory            
     */
    function add(ServiceHistory $serviceHistory, $supplierId)
    {
        $supplier = $this->em->getRepository('Cars\Entity\Suppliers')->findOneBy(array(
            "Id" => $supplierId
        ));  
        
        $serviceHistory->setSupplier($supplier);
        
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
    
    function retrieveSuppliers(){
        $suppliers = $this->em->getRepository('Cars\Entity\Suppliers')->findAll();
        
        $supplierArray = array();
        foreach ($suppliers as $item){
            $supplierArray[$item->getId()] = $item->getName();
        }
        
        return $supplierArray;
    }
}

?>