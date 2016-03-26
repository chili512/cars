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

    public function retrieveAll()
    {
        $query = $this->em->createQuery('SELECT sh.rid, sh.date, sh.carid, sh.comments, sh.odometer, s.name, sh.cost, sh.carid
            FROM  Cars\Entity\ServiceHistory sh JOIN sh.suppliers s
            ORDER BY sh.date DESC');
        
        $serviceHistory = $query->getResult();
        return $serviceHistory;
    }

    public function retrieveHistorySingleCar($id)
    {
        $query = $this->em->createQuery('SELECT sh.rid, sh.date, sh.carid, sh.comments, sh.odometer, s.name, sh.cost
            FROM  Cars\Entity\ServiceHistory sh JOIN sh.suppliers s
            WHERE sh.carid = :car ORDER BY sh.date DESC');
        $query->setParameter('car', $id, IntegerType::INTEGER);
        $serviceHistory = $query->getResult();
        return $serviceHistory;
    }

    /**
     * Persist to the database
     * http://codesamplez.com/database/doctrine-relations-entity-tutorial assisted in this
     *
     * @param ServiceHistory $serviceHistory            
     */
    public function add(ServiceHistory $serviceHistory, $supplierId)
    {
        try {
            $supplier = $this->getSupplier($supplierId);
            $serviceHistory->setSupplier($supplier);
            $this->save($serviceHistory);
        } catch (Exception $e) {}
    }

    /**
     */
    private function save($serviceHistory)
    {
        $this->em->beginTransaction();
        $this->em->persist($serviceHistory);
        $this->em->flush($serviceHistory);
        $this->em->commit();
    }

    private function getSupplier($supplierId)
    {
        $supplier = $this->em->getRepository('Cars\Entity\Suppliers')->findOneBy(array(
            "Id" => $supplierId
        ));
        return $supplier;
    }

    public function retrieveSuppliers()
    {
        $suppliers = $this->getSuppliers();
        
        $supplierArray = array();
        foreach ($suppliers as $item) {
            $supplierArray[$item->getId()] = $item->getName();
        }
        
        return $supplierArray;
    }

    private function getSuppliers()
    {
        // The table column name is Name, but the ORM is name. Case sensitive.
        $suppliers = $this->em->getRepository('Cars\Entity\Suppliers')->findBy(array(), 
            array('name' => 'ASC'));
        return $suppliers;
    }
}

?>