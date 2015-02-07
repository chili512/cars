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
        // $this->em = $em;
        echo 'Contr';
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
        echo 'found';
        $allcars = $this->em->getRepository('Cars\Entity\Overview')->findAll();
        return $allcars;
    }
}

?>