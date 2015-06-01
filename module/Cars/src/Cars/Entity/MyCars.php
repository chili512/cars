<?php
namespace Cars\Entity;

class MyCars
{
    // TODO - Insert your code here
    protected $em;

    /**
     *
     * @param EntityManager $em            
     */
    function __construct()
    {

    }

    /**
     */
    function __destruct()
    {
        $this->em->close();
    }

    /**
     * Retrieves all cars
     */
    public function retrieveAll()
    {
        $allcars = $this->em->getRepository('Cars\Entity\Overview')->findAll();
        return $allcars;
    }
}

?>