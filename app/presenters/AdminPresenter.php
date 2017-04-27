<?php

namespace App\Presenters;

use Nette;
use App\Forms;
use Nette\Application\UI\Form;


class AdminPresenter extends BasePresenter
{
	public function renderDefault(){
		$this->redirect('Admin:login');
	}

	public function createComponentLoginForm(){
		$form = new Form();
		$form->elementPrototype->setAttribute('class', 'ajax');

		$form->addText('username', 'Uživatelské jméno:', 18);
		$form->addPassword('password', 'Heslo:', 18);

		$form->addSubmit('send', 'Přihlásit se');

		$form->onSuccess[] = function (Form $form, $values) {
			try {
				$this->user->login($values['username'], $values['password']);
				$this->redirect('Homepage:');
			}catch(Nette\Security\AuthenticationException $e){
				$this->flashMessage($e->getMessage());
				$this->redirect('Admin:login');
			}
		};

		return $form;
	}

	public function renderLogin(){
		if($this->user->isLoggedIn()) $this->redirect('Homepage:');
	}

	public function actionLogout()
	{
		$this->getUser()->logout();
		$this->redirect('Homepage:');
	}

}
