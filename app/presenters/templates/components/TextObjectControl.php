<?php
namespace App\Control;

use App\Model\Entity\TextObject;
use App\Model\Repository\TextObjects;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Form;
use Tracy\Debugger;

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

    public function render($id, $multiparagraph = true)
    {
        $template = $this->template;

        $template->addFilter('markdown', function($input) {
            $md = \Parsedown::instance()->setBreaksEnabled(true);
            $html = new Nette\Utils\Html();
            return $html->setHtml($md->parse($input));
        });

        $template->addFilter('markdownLine', function($input) {
            $md = \Parsedown::instance()->setBreaksEnabled(true);
            $html = new Nette\Utils\Html();
            return $html->setHtml($md->line($input));
        });

        $textObject = $this->textObjects->getById($id);

        $template->editing = $this->getParameter('id') ? $this->getParameter('id') : false;

        $template->multiparagraph = $multiparagraph;
        $template->id = $id;

        if($textObject instanceof TextObject){
            $template->content = $textObject->getContent();
        }else{
            $template->content = '[' . $id . ']';
        }

        $template->render(__DIR__ . '/TextObjectControl.latte');
    }

    public function createComponentEditForm(){
        $form = new Form();
        $form->elementPrototype->setAttribute('class', 'ajax'); // TODO not working, dunno why

        $form->addHidden('id', $this->getParameter('id'));
        $form->addTextArea('content', 'Obsah')
            ->setAttribute('placeholder', 'Obsah textového prvku')
            ->setAttribute('autofocus')
            ->setValue(
                $this->textObjects->getById(
                    $this->getParameter('id')
                ) != null ?
                    $this->textObjects->getById($this->getParameter('id'))->getContent() : null
            );
        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = function (Form $form, $values) {
            if(!$this->presenter->user->isLoggedIn()){
                $this->flashMessage('Administrátor není přihlášen, takže nemůže provádět změny.');
            }else {
                $this->textObjects->getById($values['id'])->setContent($values['content']);
                $this->flashMessage('Změněný textový prvek byl uložen.');
            }
            $this->redirect('this');
        };
        return $form;
    }

    public function handleEdit($id){

    }
}