<?php
namespace App\Model\Repository;

use Nette;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Gallery;

class Galleries extends Nette\Object
{
    private $em;
    private $galleries;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->galleries = $em->getRepository(Gallery::class);
    }

    public function add(Gallery $object)
    {
        $this->em->persist($object)->flush();
    }

    /**
     * @return Gallery[]
     */
    public function getAll(){
        return $this->galleries->findBy(null, ['order' => 'ASC']);
    }

    /**
     * @param int $id
     * @return Gallery|null
     */
    public function getById($id){
        return $this->galleries->findOneBy(['id' => $id]);
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}