<?php

namespace App\Presenters;

use Nette;

class PricelistPresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->text = $this->textObjects->getPrintableContentById(3, true);
	}
}
