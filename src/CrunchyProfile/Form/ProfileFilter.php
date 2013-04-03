<?php

namespace CrunchyProfile\Form;

use Zend\InputFilter\InputFilter;

class ProfileFilter extends InputFilter
{
    public function __construct($options)
    {
        if (!$options || !is_array($options) || empty($options)) {
            return false;
        }
        
        // read from configuration validation rules
        foreach ($options as $key => $values) {
            if ($values && isset($values['validators']) && !empty($values['validators'])) {
                $this->add(array(
                    'name' => $key,
                    'required' => (isset($values['required']) && $values['required'] == true) ? true : false,
                    'validators' => $values['validators']
                ));
            }
        }
        
    }
}