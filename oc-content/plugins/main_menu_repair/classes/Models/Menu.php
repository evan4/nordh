<?php

/*
* Copyright 2016 osclass-pro.ru
* You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/

class Models_Menu_Repair extends DAO
{

    function __construct()
    {
        parent::__construct();
        $this->setTableName('t_main_menu_repair');
        $this->setPrimaryKey('id');
        $this->setFields(array('id', 'name', 'url', 'orderliness'));
    }

    private static $instance;

    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getMenu()
    {
        $this->dao->select($this->getFields());
        $this->dao->from($this->getTableName());
        $this->dao->orderBy('orderliness', 'ASC');
        $result = $this->dao->get();

        if ($result == false) {
            return array();
        }

        return $result->result();
    }

    public function add($array)
    {
        $aSet = array(
            'name' => $array['name'],
            'url' => $array['url'],
            'orderliness' => $array['orderliness'],
        );
        $result['res'] = $this->dao->insert($this->getTableName(), $aSet);
        $result['id'] = $this->dao->insertedId();
        return $result;
    }


    public function updateMenu($array)
    {
        $aSet = array(
            'name' => $array['name'],
            'url' => $array['url'],
            'orderliness' => $array['orderliness'],
        );
        $array_where = array(
            'id' => $array['id'],
        );
        return $this->dao->update($this->getTableName(), $aSet, $array_where);
    }

    public function delete($id)
    {
        $aSet = ['id' => $id];
        return $this->dao->delete($this->getTableName(), $aSet);
    }
}