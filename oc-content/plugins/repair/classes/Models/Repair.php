<?php

/*
* Copyright 2016 osclass-pro.ru
* You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/

class Models_Repair extends DAO
{

    function __construct()
    {
        parent::__construct();
        $this->setTableName('t_repair');
        $this->setPrimaryKey('id');
        $this->setFields(array('id', 'title', 'description', 'orderliness'));
    }

    private static $instance;

    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getSlides()
    {
        $this->dao->select($this->getFields());
        $this->dao->from($this->getTableName());
        $this->dao->orderBy('orderliness', 'ASC');
        $result = $this->dao->get();

        if ($result == false) {
            return array();
        }
        $result = $result->result();
        foreach ($result as $key => $item) {
            $images = Models_Repair_Images::newInstance()->getByFkId($item['id']);
            foreach ($images as  $image) {
                $result[$key]['image'][] = $image['name'];
            }
        }

        return $result;
    }



    public function getLastId()
    {
        $this->dao->select($this->getFields());
        $this->dao->from($this->getTableName());
        $result = $this->dao->get();

        if ($result == false) {
            return array();
        }
        $last = end($result->result());
        $id = $last['id'];

        return $id;
    }

    public function add($array)
    {
        $aSet = array(
            'title' => $array['title'],
            'description' => $array['description'],
            'orderliness' => $array['orderliness'],
        );
        $result['res'] = $this->dao->insert($this->getTableName(), $aSet);
        $result['id'] = $this->dao->insertedId();
        return $result;
    }


    public function updateItem($array)
    {
        $aSet = array(
            'title' => $array['title'],
            'description' => $array['description'],
            'orderliness' => $array['orderliness'],
        );
        $array_where = array(
            'id' => $array['id'],
        );
        return $this->dao->update($this->getTableName(), $aSet, $array_where);
    }
}