<?php

namespace App\Presenters;

use Nette;

class ContactPresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->text = $this->textObjects->getPrintableContentById(4, true);
	}
}
