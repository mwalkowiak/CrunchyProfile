<?php

namespace CrunchyProfile\Controller;

use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;
use CrunchyProfile\Entity\Profile as ProfileEntity;
use Zend\Session\Container;
use Zend\Validator\File\Size;
use Zend\Validator\File\MimeType;
use CrunchyProfile\Form\ProfileFilter as CrunchyProfileFilter;
use Zend\Debug\Debug;

class ProfileController extends AbstractActionController
{
    protected $profileService;
    protected $moduleOptions;
    protected $crunchyProfileService;


	/**
	 * Edit profile action
	 */
	public function editAction()
        {
            $service = $this->getCrunchyProfileService();

            $options = $service->getProfileFieldsOptions()->getFieldSettings();

            $form = false;
            $userId = 0;

            if ($options && is_array($options) && !empty($options)) {
                $form = $this->getServiceLocator()->get('crunchy_profile_form');
                $form->setInputFilter(new CrunchyProfileFilter($options));
                $userId = $this->zfcUserAuthentication()->getIdentity()->getId();
            }

			$validFlag = true;

			$imageFields = $service->getImageFields();

			$request = $this->getRequest();

			if ($request->isPost()) {

                $data = $request->getPost();
                $imageData = $request->getFiles();


                $data = array_merge_recursive(
                                $data->toArray(),
                                $imageData->toArray()
                );


                $form->setData($data);

                if ($form->isValid()) {

                    $imageFiles = array();

                    // file type section
                    foreach ($imageFields as $imageField) {
                        if (!empty($data[$imageField]) && $data[$imageField]['name'] != '') {

                            $currentField = $imageData->$imageField;


                    $size = new Size(array('max'=>2000000)); // max = 2mb
					$type = new MimeType(array('image/gif','image/jpeg','image/png'));

                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $adapter->setValidators(array($size, $type), $currentField['name']);

                    $absoluteImagePath = $service->getProfileFieldsOptions()->getAbsoluteImagePath();

                    $adapter->setDestination($absoluteImagePath);

                    $destination = '';

                    if (is_array($destination = $adapter->getDestination())) {
                            $destination = $destination[$imageField];
                    }

                    $imageFiles[$imageField] = $userId . time() . $currentField['name'];

					$destinationPath = $destination .'/' . $imageFiles[$imageField];

                    $adapter->addFilter('File\Rename',
                        array('target' => $destinationPath, 'overwrite' => true));



                    if (!$adapter->receive($currentField['name'])) {
                        $this->flashMessenger()->addErrorMessage('An error occured while uploading profile image: ' . $currentField['name']);

                        foreach ($adapter->getErrors() as $error) {
                            switch ($error) {
                                case 'fileSizeTooSmall':
                                        $this->flashMessenger()->addErrorMessage('File size is too small. It should be at least 20kb.');
                                        break;
                                case 'fileSizeTooBig':
                                        $this->flashMessenger()->addErrorMessage('File size is too big. It should be max 2mb.');
                                        break;
								case 'fileMimeTypeFalse':
                                        $this->flashMessenger()->addErrorMessage('File has wrong type. Only jpg, gif and png images are allowed.');
                                        break;
                                default:
                                        break;
                            }
                        }
						$validFlag = false;
                    } else {

                    	// Imagine picture processing
						$imagine = $this->getImagineService();

						$size = new \Imagine\Image\Box(150, 150);
						$mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

						$image = $imagine->open($destinationPath);
						$image->thumbnail($size, $mode)->save($destinationPath);
                    }

                }
            }

			if ($validFlag) {
				$formData = $form->getData();

	            foreach ($formData as $key => $value) {

	                if ($key != 'id' && $key != 'submit') {


	                    if (in_array($key, $imageFields) && $imageFiles[$key] != '') {
	                            $value = $imageFiles[$key];
	                    }

	                    $record = array(
	                            'key' => $key,
	                            'value' => $value,
	                            'user_id' => $userId
	                    );

	                    if (in_array($key, $imageFields) && $imageFiles[$key] == '') {
	                        continue;
	                    } else {
	                        $service->save($record);
	                    }
	                }
	            }

				$this->flashMessenger()->addSuccessMessage('Profile has been successfully updated.');
			}

            $this->redirect()->toRoute('zfcuser/profile');
          }
		}

		if ($form) {
			$profile = $service->findProfileData();
			if ($profile) {
				$form->populateValues($profile);
			}
		}


		$imagePaths = array();

		$profileData = $service->getUserProfileData($userId);

		if ($imageFields && !empty($imageFields)) {
                 foreach ($profileData as $property) {
                    if (in_array($property->getKey(), $imageFields)) {
                        $imagePaths[$property->getKey()] = '/' . $service->getProfileFieldsOptions()->getImagePath() . '/' . $property->getValue();
                    }
            }
        }


        return array(
            'form' => $form,
            'options' => $options,
            'images' => $imagePaths,
            'validFlag' => $validFlag
        );
    }

    protected function getModuleOptions()
    {
        if ($this->moduleOptions === null) {
            $this->moduleOptions = $this->getServiceLocator()->get('crunchyprofile_module_options');
        }
        return $this->moduleOptions;
    }

	public function getCrunchyProfileService()
    {
        if ($this->crunchyProfileService === null)
        {
            $this->crunchyProfileService = $this->getServiceLocator()->get('crunchyprofile_profile_service');
        }
        return $this->crunchyProfileService;
    }

	public function getImagineService()
    {
        if ($this->imagineService === null)
        {
            $this->imagineService = $this->getServiceLocator()->get('crunchy_image_service');
        }
        return $this->imagineService;
    }
}
