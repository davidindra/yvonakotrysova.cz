<?php

namespace App\Presenters;

use Nette;
use App\Model;
use App\Model\Repository\TextObjects;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @inject
     * @var TextObjects
     */
    public $textObjects;

    public function beforeRender()
    {
        foreach(['title', 'nav', 'content', 'pageNameJS', 'flashes'] as $snippet){
            $this->redrawControl($snippet);
        }
        parent::beforeRender();
    }
}
