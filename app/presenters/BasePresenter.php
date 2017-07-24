<?php

namespace App\Presenters;

use App\Control\TextObjectControl;
use App\Model\Repository\Galleries;
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

    /**
     * @inject
     * @var TextObjectControl
     */
    public $textObjectControl;

    /**
     * @inject
     * @var Galleries
     */
    public $galleries;

    public function beforeRender()
    {
        $this->template->galleries = $this->galleries->getAll();

        $this->addFilters();

        foreach(['title', 'nav', 'content', 'pageNameJS', 'flashes'] as $snippet){
            $this->redrawControl($snippet);
        }

        parent::beforeRender();
    }

    protected function createComponentTextObject()
    {
        return $this->textObjectControl;
    }

    private function addFilters(){
        $this->template->addFilter('dump', function ($input) {
            $html = new Nette\Utils\Html();
            return $html->setHtml(Debugger::dump($input, true));
        });
    }
}
