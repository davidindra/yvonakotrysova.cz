<?php
namespace App\Model\Repository;

use Nette;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\TextObject;

class TextObjects extends Nette\Object
{
    private $em;
    private $textObjects;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->textObjects = $em->getRepository(TextObject::class);
    }

    public function add(TextObject $object)
    {
        $this->em->persist($object)->flush();
    }

    /**
     * @return TextObject[]
     */
    public function getAll(){
        return $this->textObjects->findAll();
    }

    /**
     * @param int $id
     * @return TextObject|null
     */
    public function getById($id){
        return $this->textObjects->findOneBy(['id' => $id]);
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}