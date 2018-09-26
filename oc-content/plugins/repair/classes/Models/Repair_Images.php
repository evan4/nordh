<?php

/*
* Copyright 2016 osclass-pro.ru
* You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/

class Models_Repair_Images extends DAO
{
    private $upload_path;

    function __construct()
    {
        parent::__construct();
        $this->setTableName('t_repair_images');
        $this->setFields(array('fk_id', 'name'));
        $this->upload_path = osc_content_path() . 'uploads/repair';
    }

    private static $instance;

    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getByFkId($fkId = 0)
    {
        if ($fkId) {
            $key = md5(osc_base_url() . 'RepairItemResource:getAllResourcesFromItem:' . $fkId);
            $found = null;
            $cache = osc_cache_get($key, $found);
            if ($cache === false) {
                $this->dao->select($this->getFields());
                $this->dao->from($this->getTableName());
                $this->dao->where('fk_id', $fkId);
                $result = $this->dao->get();

                if ($result == false) {
                    return array();
                }
                $return = $result->result();
                osc_cache_set($key, $return, OSC_CACHE_TTL);
                return $return;
            } else {
                return $cache;
            }
        } else {
            return array();
        }
    }

    public function add($array)
    {
        $aSet = array(
            'fk_id' => $array['id'],
            'name' => $array['name'],
        );
        $result['res'] = $this->dao->insert($this->getTableName(), $aSet);
        return $result;
    }

    public function updateService($array)
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

    public function deleteByFkId($id)
    {
        $res = $this->getByFkId($id);
        foreach ($res as $item) {
            $this->delete($item['fk_id']);
            $this->deletePhisical($this->upload_path . '/' . $item['name']);
            $this->deletePhisical($this->upload_path . '/preview_' . $item['name']);
        }
    }

    public function deleteByName($name)
    {
        $aSet = ['name' => $name];
        $this->deletePhisical($this->upload_path . '/' . $name);
        $this->deletePhisical($this->upload_path . '/preview_' . $name);

        return $this->dao->delete($this->getTableName(), $aSet);
    }

    public function delete($id)
    {
        $aSet = ['fk_id' => $id];
        $key = md5(osc_base_url() . 'RepairItemResource:getAllResourcesFromItem:' . $id);
        $found = null;
        $cache = osc_cache_get($key, $found);
        $return = $this->dao->delete($this->getTableName(), $aSet);
        if ($cache !== false) {
            osc_cache_set($key, $return, OSC_CACHE_TTL);
        }
        return $return;
    }

    private function deletePhisical($img)
    {
        try {
            if (file_exists($img) && is_writable($img)) {
                unlink($img);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
            echo $exc->getTraceAsString();
        }
    }
}