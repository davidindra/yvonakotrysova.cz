<?php

namespace App\Presenters;

use Nette;
use App\Model;

class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->quote = $this->textObjects->getPrintableContentById(1);
	}

}
