<?php

namespace CrunchyProfile\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Profile extends AbstractDbMapper
{
    protected $tableName = 'user_profile';

    public function getAll($status = null)
    {
        $select = $this->getSelect();
        if(null != $status) {
            $select->where(array('status' => $status));
        }
        return $this->select($select);
    }

    public function getUserProfileData($userId) 
    {
        $params = array(
    		'user_id' => $userId
		);

        $select = $this->getSelect();
		$select->where($params);

        return $this->select($select);
    }

    public function saveProfileRecord($obj)
    {
        $this->insert($obj, $this->_tableName);
    }
	
    public function updateProfileRecord($obj)
    {
        return parent::update($obj, array('id' => $obj->getId()));
    }
	
    public function getProfileKey($key, $userId) 
    {
        $params = array(
                'key' => $key,
                'user_id' => $userId
        );

        $select = $this->getSelect();
        $select->where($params)->limit(1);

        return $this->select($select);		
    }

    /**
     * Get user profile data to populate in form
     */
    public function findProfileData($userId)
    {
        $select = $this->getSelect();
        $select->where(array(
            'user_id' => $userId
        ));

        return $this->select($select);
    }
}