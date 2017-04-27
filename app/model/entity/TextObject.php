<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class TextObject
{
    use Identifier;

    /**
     * @ORM\Column(type="string", length=1000000)
     */
    protected $content;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $lastUpdate;

    public function __construct()
    {
        $this->lastUpdate = time();
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
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