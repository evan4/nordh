<?php

/*
* Copyright 2016 osclass-pro.ru
* You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/

class Models_Advantages extends DAO
{

    private $upload_path;

    function __construct()
    {
        parent::__construct();
        $this->setTableName('t_advantages');
        $this->setPrimaryKey('id');
        $this->setFields(array('id', 'title', 'description', 'avatar', 'orderliness'));
        $this->upload_path = osc_content_path() . 'uploads/advantages';
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

        return $result;
    }

    public function add($array)
    {
        $aSet = array(
            'title' => $array['title'],
            'description' => $array['description'],
            'avatar' => $array['avatar'],
            'orderliness' => $array['orderliness'],
        );
        $result['res'] = $this->dao->insert($this->getTableName(), $aSet);
        $result['id'] = $this->dao->insertedId();
        return $result;
    }


    public function updateItem($array, $id)
    {
        $array_where = array(
            'id' => $id,
        );
        return $this->dao->update($this->getTableName(), $array, $array_where);
    }

    public function deleteImage($name)
    {
        $img = $this->upload_path . '/' . $name;
        $id = explode('.', $name);
        try {

            if (file_exists($img) && is_writable($img)) {
                unlink($img);

            }else{
                //return false;
            }
            $aSet = array(
                'avatar' => ''
            );
            $array_where = array(
                'id' => intval($id[0])
            );
            return $this->dao->update($this->getTableName(), $aSet, $array_where);
        } catch (Exception $exc) {
            echo $exc->getMessage();
            echo $exc->getTraceAsString();
            return false;
        }

    }
}