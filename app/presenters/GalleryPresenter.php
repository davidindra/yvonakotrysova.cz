<?php

namespace App\Presenters;

use App\Model\Entity\Photo;
use App\Model\Repository\Galleries;
use App\Model\Repository\Photos;
use Nette;
use Nette\Application\UI\Form;
use Nette\Image;

class GalleryPresenter extends BasePresenter
{
	/**
     * @inject
     * @var Galleries
     */
    public $galleries;

    /**
     * @inject
     * @var Photos
     */
    public $photos;

    public function renderDefault(int $id)
	{
        $this->template->gallery = $this->galleries->getById($id);
	}

    public function createComponentAdderForm(){
        $form = new Form();
        $form->elementPrototype->setAttribute('class', 'ajax');

        $form->addHidden('galleryId');

        $form->addMultiUpload('image', 'Fotografie:')
            ->addRule(Form::FILLED, 'Zvolte, prosím, nějaký soubor k přidání.');

        $form->addSubmit('send', 'Přidat do fotogalerie');

        $form->onSuccess[] = function (Form $form, $values) {

            if(!$this->user->isLoggedIn()){
                $this->error('Musíte být přihlášen/a jako administrátor.');
            }

            foreach($values['image'] as $file) {

                if ($file->isImage() && $file->isOk()) {

                    $notifyFailed = false;
                    $failedImages = [];

                    try{

                        $extension = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));

                        $unique = uniqid(rand(0, 20), TRUE);

                        $fileName = $unique . $extension;
                        $pathWww = '/img/gallery/' . $fileName;
                        $pathApp = __DIR__ . '/../../www' . $pathWww;

                        $fileNameThumb = $unique . '.thumb' . $extension;
                        $pathWwwThumb = '/img/gallery/' . $fileNameThumb;
                        $pathAppThumb = __DIR__ . '/../../www' . $pathWwwThumb;

                        if (!is_dir(pathinfo($pathApp)['dirname'])) mkdir(pathinfo($pathApp)['dirname']);

                        $file->move($pathApp);

                        $image = Image::fromFile($pathApp);
                        if ($image->getWidth() > $image->getHeight()) {
                            $image->resize(300, NULL);
                        } else {
                            $image->resize(NULL, 225);
                        }
                        $image->sharpen();
                        $image->save($pathAppThumb);

                        $photo = new Photo();
                        $photo->setOwningGallery($this->galleries->getById($values['galleryId']));
                        $photo->setOrder($this->photos->getLastId() + 1);
                        $photo->setSource($pathWww);
                        $photo->setSourcePreview($pathWwwThumb);

                        $this->photos->add($photo);

                    }catch(\Exception $e){
                        $notifyFailed = true;
                        $failedImages[] = $file->getSanitizedName();
                    }

                } else {
                    $this->error('Nahrání fotografie selhalo.', Nette\Http\IResponse::S500_INTERNAL_SERVER_ERROR);
                }

            }

            if($notifyFailed){
                if(count($values['image']) == 1)
                    $this->flashMessage('Nahrání fotografie selhalo.');
                else
                    $this->flashMessage('Nahrání následujících fotografií selhalo: ' . implode(', ', $failedImages));
            }else{
                if(count($values['image']) == 1)
                    $this->flashMessage('Fotografie byla úspěšně nahrána.');
                else
                    $this->flashMessage('Fotografie byly úspěšně nahrány.');
            }
        };

        return $form;
    }
}
