<?php

/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 12.02.18
 * Time: 11:28
 */
class Models_User_Photo extends DAO
{
    function __construct()
    {
        parent::__construct();
        $this->setTableName('t_user_photo');
        $this->setPrimaryKey('id');
        $this->setFields(array('id', 'user_name', 'pic_ext'));
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
    public function add($name, $photo, $photo_name)
    {
        $aSet = array(
            'user_name' => $name,
            'pic_ext' => $photo_name
        );
        $this->loadImage($photo, $photo_name);
        $result = $this->dao->insert($this->getTableName(), $aSet);

        return $result;
    }

    public function edit($id, $photo, $photo_name)
    {
        $aSet = array(
            'pic_ext' => $photo_name
        );
        $array_where = array(
            'id' => $id,
        );

        $this->loadImage($photo, $photo_name);
        return $this->dao->update($this->getTableName(), $aSet, $array_where);
    }

    public function getByName($name)
    {
        $this->dao->select($this->getFields());
        $this->dao->from($this->getTableName());
        $this->dao->where('user_name', $name);
        $result = $this->dao->get();

        if ($result == false) {
            return array();
        }

        return $result->result();
    }

    public function delete_user($name)
    {
        return $this->dao->delete($this->getTableName(), ['user_name' => $name]);
    }

    function loadImage($photo, $photo_name)
    {
        $upload_path = osc_content_path() . 'uploads/profile/';

        $img =  $upload_path.$photo_name;

        file_put_contents($img, file_get_contents($photo));
        $size = explode('x', osc_preview_dimensions());
        ImageProcessing::fromFile( $img)->resizeTo($size[0], $size[1])->saveToFile($img, 'jpg');
    }
}