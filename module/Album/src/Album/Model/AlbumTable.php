<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * A class that interacts with database
 * @author jon
 *
 */
class AlbumTable
{

    /**
     *
     * @var unknown
     */
    protected $tableGateway;

    /**
     * Constructor
     * 
     * @param TableGateway $tableGateway            
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Get all
     * 
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /**
     * Retrieve an album
     * 
     * @param unknown $id            
     * @throws \Exception
     * @return Ambigous <multitype:, ArrayObject, NULL, \ArrayObject, unknown>
     */
    public function getAlbum($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array(
            'id' => $id
        ));
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    /**
     * Save the new album
     * 
     * @param Album $album            
     * @throws \Exception
     */
    public function saveAlbum(Album $album)
    {
        $data = array(
            'artist' => $album->artist,
            'title' => $album->title
        );
        
        $id = (int) $album->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
    }

    /**
     * Delete an album
     * @param unknown $id
     */
    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id
        ));
    }
}

?>