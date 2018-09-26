<?php

/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 12.02.18
 * Time: 11:28
 */
class Models_Districts extends DAO
{
    function __construct()
    {
        parent::__construct();
        $this->setTableName('t_districts');
        $this->setPrimaryKey('pk_i_id');
        $this->setFields(array('pk_i_id', 's_name'));
    }

    /**
     * Singleton.
     */
    private static $instance;

    /**
     * Singleton constructor.
     * @return an ModelFilterSearchDAO object.
     */
    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function insertNewDistrict($array)
    {
        $aSet = array(
            'fk_i_city_id' => $array['parent'],
            's_name' => $array['name']
        );
        $result['res'] = $this->dao->insert($this->getTableName(), $aSet);
        $result['id'] = $this->dao->insertedId();
        return $result;
    }

    public function updateDistrict($array)
    {
        $aSet = array(
            's_name' => $array['name']
        );
        $array_where = array(
            'pk_i_id' => $array['id'],
        );
        return $this->dao->update($this->getTableName(), $aSet, $array_where);
    }

    public function getByCityId($id)
    {
        $this->dao->select($this->getFields());
        $this->dao->from($this->getTableName());
        $this->dao->where('fk_i_city_id', $id);
        $this->dao->orderBy('s_name', 'ASC');
        $result = $this->dao->get();

        if ($result == false) {
            return array();
        }

        return $result->result();
    }

    public function delete($id)
    {
        return $this->dao->delete($this->getTableName(), ['pk_i_id' => $id]);
    }

}