<?php
namespace Cars\Models;

use Doctrine\ORM\EntityManager;
use Cars\Entity\Automobile;
use Cars\Entity\Model;

/**
 * An object that handles interaction with the MySql database using Doctrine 2
 * 
 * @author jon
 *        
 */
class CarTable
{

    /**
     * The Doctrine entity manager
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * The entity manager is injected as a dependency
     *
     * @param EntityManager $em            
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     */
    function __destruct()
    {
        $this->em->close();
    }

    /**
     * Retrieves all cars using Doctrine query language
     * http://doctrine-orm.readthedocs.org/en/latest/reference/dql-doctrine-query-language.html 
     * 
     */
    public function retrieveAll()
    {
        // This is the original method of retrieving the data. It takes about 1.84ms
        // $allcars = $this->em->getRepository('Cars\Entity\Overview')->findAll();
        // It was replace by this method that uses the Doctrine query language. It takes 1.23ms
        // The times may be a result of database caching as one query ran immediately after the other
        $query = $this->em->createQuery('SELECT m From \Cars\Entity\Overview m ORDER BY m.modelyear DESC');
        
        // Execute the query and return the results
        $allcars = $query->getResult();
        return $allcars;
    }

    /**
     * Gets the transmissions
     *
     * @return multitype:NULL
     */
    public function transmissions()
    {
        $data = $this->em->getRepository('Cars\Entity\Transmissions')->findAll();
        $transmissions = array();
        
        foreach ($data as $item) {
            $transmissions[$item->getId()] = $item->getTransmissionType();
        }
        
        return $transmissions;
    }

    /**
     * Get the body types
     *
     * @return multitype:NULL
     */
    public function bodyTypes()
    {
        $data = $this->em->getRepository('Cars\Entity\BodyType')->findAll();
        $types = array();
        
        foreach ($data as $item) {
            $types[$item->getId()] = $item->getName();
        }
        
        return $types;
    }

    /**
     * A list of manufacturers
     *
     * @return multitype:NULL
     */
    public function manufacturers()
    {
        $data = $this->em->getRepository('Cars\Entity\Manufacturer')->findAll();
        $types = array();
        
        foreach ($data as $item) {
            $types[$item->getId()] = $item->getName();
        }
        
        return $types;
    }

    /**
     * This function persists the object to the database.
     * Code is based on 
     * http://marco-pivetta.com/doctrine-orm-zf2-tutorial/#/28/1
     * 
     * @param Automobile $auto            
     */
    public function save(Automobile $auto)
    {
        $this->em->beginTransaction();
        $this->em->persist($auto);
        $this->em->flush($auto);
        $this->em->commit();
    }

    /**
     * Get the model ID using Doctrine query language
     *
     * @param string $name            
     */
    public function getModelId($name)
    {
        // Build a Doctrine query
        $query = $this->em->createQuery('SELECT u.id FROM Cars\Entity\Model u WHERE u.name = ?1');
        
        // Add a parameter
        $query->setParameter(1, $name);
        
        // Declare a variable that represents the ID field of the object we are searching for
        $id = 0;
        
        // Get the result which may be null (not found)
        $result = $query->getResult();
        if ($result == null) {
            
            // Create a new record and assign the name
            $model = new Model();
            $model->SetName($name);
            
            // Persist
            $this->em->persist($model);
            
            // Commit to the database
            $this->em->flush($model);
            
            // Retrieve the ID
            $id = $model->GetId();            
        } else {
            
            $id = $result[0]['id'];
        }
        
        return $id;
    }
    
    /**
     * Retrieve a specific automobile by its primary key
     * 
     * @param unknown $id
     */
    public function getAutomobile($id){
        
        $data = $this->em->find('Cars\Entity\CarDetails', $id);
        
        return $data;
    }
}

?>