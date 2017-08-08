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
     * @ORM\Column(name="`order`", type="integer", nullable=true)
     */
    protected $order;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $lastUpdate;

    public function __construct()
    {
        $this->lastUpdate = new \DateTime();
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function setSourcePreview($sourcePreview)
    {
        $this->sourcePreview = $sourcePreview;
    }

    public function getSourcePreview()
    {
        return $this->sourcePreview;
    }

    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOwningGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }
}