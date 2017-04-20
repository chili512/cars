<?php

namespace Cars\Models;

use Doctrine\ORM\EntityManager;
use Cars\Entity\ServiceHistory as ServiceHistory;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\Query;

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
     * @return array
     */
    public function retrieveAll()
    {
        $query = $this->em->createQuery('SELECT sh.rid, sh.date, sh.carid, sh.comments, sh.odometer, s.name, sh.cost, sh.carid
            FROM  ServiceHistory sh JOIN sh.suppliers s
            ORDER BY sh.date DESC');

        $serviceHistory = $query->getResult();
        return $serviceHistory;
    }

    /**
     * @param $id
     * @return array
     */
    public function retrieveHistorySingleCar($id)
    {
        $query = $this->em->createQuery('SELECT sh.rid, sh.date, sh.carid, sh.comments, sh.odometer, s.name, sh.cost
            FROM  ServiceHistory sh JOIN sh.suppliers s
            WHERE sh.carid = :car ORDER BY sh.date DESC');
        $query->setParameter('car', $id, IntegerType::INTEGER);
        $serviceHistory = $query->getResult();
        return $serviceHistory;
    }

    /**
     * @param $id
     * @return float
     */
    public function sumServiceCostForCar($id)
    {

        $query = $this->em->createQuery('SELECT SUM(s.cost) FROM ServiceHistory s WHERE s.carid = :car');
        $query->setParameter('car', $id);
        $result = $query->getResult();
        return (double)$result[0][1];
    }

    /**
     * @return float
     */
    public function sumAllServiceCosts()
    {

        $query = $this->em->createQuery('SELECT SUM(s.cost) FROM ServiceHistory s');
        $result = $query->getResult();
        return (double)$result[0][1];
    }

    /**
     * http://codesamplez.com/database/doctrine-relations-entity-tutorial assisted in this
     * @param ServiceHistory $serviceHistory
     * @param $supplierId
     */
    public function add(ServiceHistory $serviceHistory, $supplierId)
    {
        try {
            $supplier = $this->getSupplier($supplierId);
            $serviceHistory->setSupplier($supplier);
            $this->save($serviceHistory);
        } catch (Exception $e) {
        }
    }

    /**
     * @param $serviceHistory
     */
    private function save($serviceHistory)
    {
        $this->em->beginTransaction();
        $this->em->persist($serviceHistory);
        $this->em->flush($serviceHistory);
        $this->em->commit();
    }

    /**
     * @param $supplierId
     * @return null|object
     */
    private function getSupplier($supplierId)
    {
        $supplier = $this->em->getRepository('Cars\Entity\Suppliers')->findOneBy(array(
            "Id" => $supplierId
        ));
        return $supplier;
    }

    /**
     * @return array
     */
    public function retrieveSuppliers()
    {
        $suppliers = $this->getSuppliers();

        $supplierArray = array();
        foreach ($suppliers as $item) {
            $supplierArray[$item->getId()] = $item->getName();
        }

        return $supplierArray;
    }

    /**
     * @return array
     */
    private function getSuppliers()
    {
        // The table column name is Name, but the ORM is name. Case sensitive.
        $suppliers = $this->em->getRepository('Cars\Entity\Suppliers')->findBy(array(),
            array('name' => 'ASC'));
        return $suppliers;
    }
}

?>