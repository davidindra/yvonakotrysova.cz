<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * @ORM\Entity
 */
class Photo
{
    use Identifier;

    /**
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="photos")
     */
    protected $gallery;

    /**
     * @ORM\Column(type="string", length=300)
     */
    protected $source;

    /**
     * @ORM\Column(type="string", length=300)
     */
    protected $sourcePreview;

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

    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getSourcePreview()
    {
        return $this->sourcePreview;
    }

    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }
}