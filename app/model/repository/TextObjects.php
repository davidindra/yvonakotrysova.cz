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

    /**
     * Gets object's content and returns its content or (when non existent) "[ID]"
     * @param int $id
     * @return string
     */
    public function getPrintableContentById($id, $markdown = false){
        /** @var TextObject */
        $textObject = $this->textObjects->findOneBy(['id' => $id]);
        if(is_null($textObject)) {
            return '[' . $id . ']';
        }else {
            if($markdown){
                $parsedown = new \Parsedown();
                return $parsedown->parse($textObject->getContent());
            }else{
                return $textObject->getContent();
            }
        }
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}