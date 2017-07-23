<?php

namespace App\Presenters;

use App\Model\Repository\Galleries;
use Nette;

class GalleryPresenter extends BasePresenter
{
	/**
     * @inject
     * @var Galleries
     */
    public $galleries;

    public function renderDefault(int $id)
	{
        $this->template->gallery = $this->galleries->getById($id);
	}
}
