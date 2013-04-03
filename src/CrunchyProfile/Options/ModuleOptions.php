<?php
namespace CrunchyProfile\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $fieldSettings;
    protected $imagePath = 'images';
    protected $absoluteImagePath;

    public function setFieldSettings($settings)
    {
        $this->fieldSettings = $settings;
        return $this;
    }

    public function getFieldSettings()
    {
        return $this->fieldSettings;
    }
    
    public function setImagePath($settings)
    {
        $this->imagePath = $settings;
        return $this;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }
    
    public function setAbsoluteImagePath($settings)
    {
        $this->absoluteImagePath = $settings;
        return $this;
    }

    public function getAbsoluteImagePath()
    {
        return $this->absoluteImagePath;
    }
}
