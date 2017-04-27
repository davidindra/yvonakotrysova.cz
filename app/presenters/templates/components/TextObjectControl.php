<?php
namespace App\Control;

use App\Model\Entity\TextObject;
use App\Model\Repository\TextObjects;
use Nette;
use Nette\Application\UI;

class TextObjectControl extends UI\Control
{
    /**
     * @var TextObjects
     */
    public $textObjects;

    public function __construct(TextObjects $textObjects)
    {
        $this->textObjects = $textObjects;
    }

    public function render($id, $paragraph = true)
    {
        $template = $this->template;

        $template->addFilter('markdown', function($input) {
            $md = \Parsedown::instance();
            $html = new Nette\Utils\Html();
            return $html->setHtml($md->line($this->template->getLatte()->invokeFilter('breaklines', [$input])));
        });

        $textObject = $this->textObjects->getById($id);

        $template->paragraph = $paragraph;
        $template->id = $id;
        if($textObject instanceof TextObject){
            $template->content = $textObject->getContent();
        }else{
            $template->content = '[' . $id . ']';
        }

        $template->render(__DIR__ . '/TextObjectControl.latte');
    }
}