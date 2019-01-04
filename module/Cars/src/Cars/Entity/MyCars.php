<?php

namespace Cars\Entity;

class MyCars
{
    protected $em;

    /**
     * MyCars constructor.
     */
    function __construct()
    {

    }

    /**
     *
     */
    function __destruct()
    {
        $this->em->close();
    }

    /**
     * @return mixed
     */
    public function retrieveAll()
    {
        $allcars = $this->em->getRepository('Cars\Entity\Overview')->findAll();
        return $allcars;
    }
}

?>