<?php
namespace CrunchyProfile\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use CrunchyProfile\Service\Profile as ProfileService;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Debug\Debug;

class Profile extends Form
{
    protected $_profileModel;
    protected $_profileService;

    protected $_inputFilter;

    public function __construct(ProfileService $service)
    {
        parent::__construct();
        
        $this->_profileService = $service;
		
        $fields = $this->_profileService->getProfileFieldsOptions()->getFieldSettings();
		
		
        // we want to ignore the name passed
        parent::__construct('profile');
        $this->setAttribute('method', 'post');
        $this->setAttributes(array(
            'method' => 'post',
            'class' => 'form-horizontal',
            'action' => '/user/profile'
        ));
		
		
		$this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
		
        // main loop for logic populating form fields depending on configuration and db values
        foreach ($fields as $name => $property) {

                if ($property['enable']) {
                    switch ($property['type']) {
                        case 'text':
                                $currentField = new Element\Text("$name");
                                break;
                        case 'email':
                                $currentField = new Element\Email("$name");
                                break;
                        case 'password':
                                $currentField = new Element\Password("$name");
                                break;
                        case 'image':
                                $currentField = new Element\File("$name");
                                break;
                        case 'textarea':
                                $currentField = new Element\Textarea("$name");
                                $currentField->setAttribute('rows', $property['rows'] ? $property['rows'] : '10');
                                break;
                        default:
                                break;
                    }

                    $currentField->setLabel($property['label']);
                    $currentField->setAttribute('disabled', isset($property['editable']) ? '' : 'disabled');
                    $currentField->setAttribute('class', isset($property['class']) ? $property['class'] : 'input-xxlarge');

                    $this->add($currentField);
                }

        }

        // submit
        $submit = new Element\Submit('submit');
        $submit->setValue('Update profile');
        $submit->setAttribute('class', 'btn btn-success');

        $this->add($submit);
    }
	
}