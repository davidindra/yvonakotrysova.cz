<?php
namespace App\Model\Repository;

use Nette;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Photo;

class Photos extends Nette\Object
{
    private $em;
    private $photos;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->photos = $em->getRepository(Photo::class);
    }

    public function add(Photo $photo)
    {
        $this->em->persist($photo)->flush();
    }

    /**
     * @param int $id
     * @return Photo|null
     */
    public function getById($id){
        return $this->photos->findOneBy(['id' => $id]);
    }

    public function getLastId(){
        if($this->photos->countBy([]) > 0)
            return $this->photos->findOneBy([], ['order' => 'DESC'])->getId();
        else
            return 1;
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}