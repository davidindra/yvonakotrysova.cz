<?php

namespace App\Presenters;

use Nette;

class AboutPresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->text = $this->textObjects->getPrintableContentById(2, true);
	}
}
