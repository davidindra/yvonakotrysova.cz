<?php

namespace App\Presenters;

use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function beforeRender()
    {
        foreach(['title', 'nav', 'content', 'pageNameJS', 'flashes'] as $snippet){
            $this->redrawControl($snippet);
        }
        parent::beforeRender();
    }
}
