<?php

namespace CT271\Labs;

class user{
	private $db;
	public $full_name;
	public $id = -1;
	public $email;
    public $pass_word;
    public $phone;
    public $place;
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['email'])) {
			$this->email = trim($data['email']);
		}

		if (isset($data['pass_word'])) {
			$this->pass_word =hash("sha1",(trim($data['pass_word'])));

		}
		if (isset($data['full_name'])) {
			$this->full_name = trim($data['full_name']);
		}

		if (isset($data['place'])) {
			$this->place =trim($data['place']);

		}
		if (isset($data['phone'])) {
			$this->phone =trim($data['phone']);

		}
		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate():bool
	{	
		if (!$this->full_name) {
			$this->errors['full_name'] = 'Tên không được rỗng.';
		}

		$validEmail = preg_match(
			'/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/',
			$this->email
		);
		if (!$validEmail) {
            $this->errors['email'] = 'Email không hợp lệ.';
        }

		if (!$this->email) {
			$this->errors['email'] = 'Email không được rỗng.';
		}

		if (!$this->place) {
			$this->errors['place'] = 'Địa chỉ không được rỗng.';
		}

		$validPhone = preg_match(
            '/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/',
            $this->phone
        );
        if (!$validPhone) {
            $this->errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

		if(!$this->phone) {
            $this->errors['phone'] = 'Số điện thoại không được rỗng.';
        }

		if(!$this->pass_word) {
            $this->errors['pass_word'] = 'Mật khẩu không được rỗng.';
        }


		return empty($this->errors);
	}

	public function all()
	{
		$users = [];
		$stmt = $this->db->prepare('select * from user');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$user = new user($this->db);
			$user->fillFromDB($row);
			$users[] = $user;
		}
		return $users;
	}
	
	protected function fillFromDB(array $row) // truyen doi tuong tu db
	{
		[
			'id' => $this->id,
			'full_name' => $this->full_name,	
			'place' => $this->place,
			'phone' => $this->phone,
			'email' => $this->email,
            'pass_word' => $this->pass_word,

		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare(
				'update user set email = :email,
					pass_word = :pass_word where id = :id'
			);
			$result = $stmt->execute([
				'name' => $this->full_name,
				'email' => $this->email,
				'pass_word' => $this->pass_word,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into user (
					full_name,place,phone,email, pass_word) 
					values (:full_name,:place,:phone,:email, :pass_word)'
			);
			$result = $stmt->execute([
				'email' => $this->email,
				'pass_word' => $this->pass_word,
				'full_name' => $this->full_name,
				'place' => $this->place,
				'phone' => $this->phone,
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();// lay id giao dich cuoi cung
			}
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from user where id = :id');
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function update(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from user where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
