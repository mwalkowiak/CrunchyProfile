<?php

namespace CrunchyProfile\Service;

use CrunchyProfile\Entity\Profile as ProfileEntity;


class Profile extends ServiceAbstract
{

    protected $profileFieldsOptions;
	
	
    public function getAll()
    {
        return $this->getMapper()->getAll();
    }

    public function findById($id)
    {
	return $this->getMapper()->findById($id);
    }

    public function getUserProfileData($userId) 
    {
        return $this->getMapper()->getUserProfileData($userId);
    }

    public function findByIdForCurrentUser($id)
    {
        $userId = $this->getIdentity()->getId();
        return $this->getMapper()->findByIdAndUserId($id, $userId);

    }

    public function setProfileFieldsOptions($opt)
    {
        $this->profileFieldsOptions = $opt;
        return $this;
    }
	
    public function getProfileFieldsOptions()
    {
	return $this->profileFieldsOptions;
    }

    public function delete($id)
    {
        $contract = $this->findByIdForCurrentUser($id);
        if(!$contract) {
            return false;
        }

        $contract->setStatus(ContractEntity::STATUS_DELETED);
        return $this->getMapper()->update($contract);
    }
	
    /**
     * Save or update existing entity
     */
    public function save(array $data)
    {
        $record = $this->getMapper()->getProfileKey($data['key'], $data['user_id']);
        $currentData = $record->toArray();

        $now = date("Y-m-d H:i:s");

        $obj = new ProfileEntity();
        $obj->setKey($data['key']);
        $obj->setValue($data['value']);
        $obj->setUserId($data['user_id']);
        $obj->setCreatedAt($now);
        $obj->setUpdatedAt($now);

        // if this is a new record
        if (empty($currentData)) {
            $this->getMapper()->saveProfileRecord($obj);
        } else {
            // update existing record
            $obj->setCreatedAt($currentData[0]['created_at']);
            $obj->setId($currentData[0]['id']);
            $this->getMapper()->updateProfileRecord($obj);

            // if this is an image type record we delete old file under given path
            if (in_array($data['key'], $this->getImageFields())) {
                unlink($this->getProfileFieldsOptions()->getAbsoluteImagePath() . '/' . $currentData[0]['value']);
            }
        }

    }  
	
    /**
     * Get user profile data to populate in form
     * 
     * @param int $userId
     * @return array
     */
    public function findProfileData()
    {
        $userId = $this->getIdentity()->getId();
        $profileData = $this->getMapper()->findProfileData($userId);

        if (!$profileData) {
            return false;
        }

        $formValues = array();

        foreach ($profileData as $record) {
            $formValues[$record->getKey()] = $record->getValue();
        }

        return $formValues;
    }
        
        
    /**
     * Search for image field from options
     * 
     * @return array
     */
    public function getImageFields()
    {
        $options = $this->getProfileFieldsOptions()->getFieldSettings();
        
		$imageFields = array();
		
        foreach ($options as $key => $properties) {
            if ($properties['type'] == 'image') {
                $imageFields[] = $key;
            }
        }
        
        return $imageFields;
    }
}