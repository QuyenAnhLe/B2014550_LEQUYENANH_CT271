<?php

namespace CT271\Labs;

use Error;

class category {
    private $db;

    public $category_id;
    public $category_name;
    private $errors=[];

    public function getId(){
        return $this->category_id;
    }

    public function __construct($pdo){
        $this->db=$pdo;
    }

    public function fill(array $data){
        $this->category_name= trim($data[`category_name`]);
        return $this;
    }

    protected function fillFromDB(array $row){
        [
            'category_id'=> $this->category_id,
            'category_name' => $this->category_name
        ] = $row;
        return $this;
    }

    public  function get_validate_error(){
        return $this->errors;
    }

    public  function all()
    {
        $categorys=[];
        $get_data= $this->db->prepare('select * from category');
        $get_data->execute();
        while ($row = $get_data->fetch()) {
			$category = new category($this->db);
			$category->fillFromDB($row);
			$categorys[] = $category;   
		}
		return $categorys;
    }
}