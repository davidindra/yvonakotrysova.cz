<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * @ORM\Entity
 */
class Gallery
{
    use Identifier;

    /**
     * @ORM\Column(type="string", length=300)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="gallery")
     * @ORM\OrderBy(value={"order" = "ASC"})
     */
    protected $photos;

    /**
     * @ORM\Column(type="integer")
     */
    protected $order;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $lastUpdate;

    public function __construct()
    {
        $this->lastUpdate = time();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }
}