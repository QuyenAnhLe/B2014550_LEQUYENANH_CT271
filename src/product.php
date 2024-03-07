<?php

namespace CT271\Labs;

class product {
    private $db;

    private $id = -1;
	public $product_name;
	public $price;
	public $img;
	public $quantity;
    public $ngay_nhap;
	public $category_id;
	public $category_name;

	private $errors = [];

    public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data, $FILES)
	{

		$this->product_name = trim($data['product_name']);


		if (isset($data['price'])) {
			$this->price = $data['price'];
		}
		if (isset($_FILES['img'])) {
			$file = $_FILES['img'];
			$this->img = $file['name'];
			$upload_dir = 'uploads/';
			$upload_file = $upload_dir . $this->img;
			if (file_exists($upload_file)) {
				echo "File already exists.";
			} else {
				move_uploaded_file($file['tmp_name'], $upload_file);
			}
		}
		if (isset($data['category_id'])) {
			$this->category_id =  preg_replace('/\D+/', '', $data['category_id']);
		}
		if (isset($data['quantity'])) {
			$this->quantity = trim($data['quantity']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

    public function validate()
	{
		if (!$this->product_name) {
			$this->errors['product_name'] = 'Tên sản phẩm không để trống.';
		}
		if (!$this->price) {
			$this->errors['price'] = 'Giá không để trống.';
		} elseif ($this->price > 45000) {
			$this->errors['price'] = 'Giá không thể lớn hơn 45000đ.';
		}
		if (!$this->img) {
			$this->errors['img'] = 'Hình ảnh không để trống.';
		}
		if (!$this->quantity) {
			$this->errors['quantity'] = 'Số lượng không để trống.';
		} elseif (($this->quantity) < 0 || ($this->quantity) > 50) {
			$this->errors['quantity'] = 'Số lượng không được phép nhỏ hơn 0 và lớn hơn 50.';
		}
		return empty($this->errors); //
	}

    public  function all()
    {
        $products=[];
        $get_data= $this->db->prepare('select * from product');
        $get_data->execute();
        while ($row = $get_data->fetch()) {
			$product = new product($this->db);
			$product->fillFromDB($row);
			$products[] = $product;   
		}
		return $products;
    }

	public function COUNT()
	{
		$stmt = $this->db->prepare('select COUNT(id) from product');
		$stmt->execute();
		$count = $stmt->fetch();
		$count1 = $count[0];
		return $count1;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'product_name' => $this->product_name,
			'price' => $this->price,
			'img' => $this->img,
			'category_id' => $this->category_id,
			'quantity' => $this->quantity,
			'ngay_nhap' => $this->ngay_nhap
			
		] = $row;
		return $this;
	}

	public function save(){
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update product set product_name = :product_name,
			price = :price, img = :img,category_id = :category_id, quantity = :quantity, ngay_nhap = now() where id = :id');
			$result = $stmt->execute([
                'id' => $this->id,
                'product_name' => $this->product_name,
                'price' => $this->price,
                'img' => $this->img,
                'category_id' => $this->category_id,
                'quantity' => $this->quantity
                
				

			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into product (product_name, price,quantity,img,category_id,ngay_nhap)
						values (:product_name, :price,:quantity, :img,:category_id,now())'
			);
			$result = $stmt->execute([
                'product_name' => $this->product_name,
                'price' => $this->price,
                'img' => $this->img,
                'category_id' => $this->category_id,
                'quantity' => $this->quantity
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId(); // lay id giao dich cuoi cung
			}
		}

		return $result;
	}
	public function find($id){
		$stmt = $this->db->prepare('SELECT * FROM product WHERE id = :id');
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function update(array $data, $FILES)
	{
		$this->fill($data, $FILES);

		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from product where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
	
    public function have_id($id){
        $products=[];
        $get_data=$this->db->prepare('SELECT * FROM product WHERE id= :id');
        $get_data->execute(['id' => $id]);
        while ($row = $get_data->fetch()) {
			$product = new product($this->db);
			$product->fillFromDB($row);
			$products[] = $product;   
		}
		return $products;
    }
    public function all_have_idloai($category_id){
        $products=[];
        $get_data=$this->db->prepare('SELECT * FROM product WHERE category_id = :category_id');
        $get_data->execute(['category_id' => $category_id]);
		while ($row = $get_data->fetch()) {
			$product = new product($this->db);
			$product->fillFromDB($row);
			$products[] = $product;   
		}
		return $products;
    }

    public function all_have_ten($product_name){
        $products=[];
        $get_data=$this->db->prepare("SELECT * FROM product WHERE product_name LIKE :product_name");
        $get_data->execute(['product_name'=>"%$product_name%"]);
        while ($row = $get_data->fetch()) {
			$product = new product($this->db);
			$product->fillFromDB($row);
			$products[] = $product;   
		}
        return $products;
    }
}
