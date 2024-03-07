<?php

namespace CT271\Labs;

class admin{
	private $db;
	private $id = -1;
	public $full_name;
	public $email;
    public $pass_word;
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
		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

    public function validate()
	{
		if (!$this->email) {
			$this->errors['email'] = 'Email không được rỗng.';
		}
        if (!$this->pass_word) {
			$this->errors['pass_word'] = 'Mật khẩu không được rỗng.';
		}

		return empty($this->errors);
	}


	public function all()
	{
		$admins = [];
		$stmt = $this->db->prepare('select * from admin');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$admin = new admin($this->db);
			$admin->fillFromDB($row);
			$admins[] = $admin;
		}
		return $admins;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'full_name' => $this->full_name,
            'email' => $this->email,
			'pass_word' => $this->pass_word,
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('
            update admin set full_name = :full_name,
                email = :email, mat_khau = :mat_khau, where id = :id'
            );
			$result = $stmt->execute([
				'full_name' => $this->full_name,
				'email' => $this->email,
				'pass_word' => $this->pass_word,
				'id' => $this->id,
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into admin (full_name, email, pass_word)
                    values (:full_name, :email, :pass_word)'
			);
			$result = $stmt->execute([
				'email' => $this->email,
				'pass_word' => $this->pass_word
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();// lay id giao dich cuoi cung
			}
		}
		return $result;
	}

	public function find($id)
	{
		$stmt = $this->db->prepare('select * from admin where id_nv = :id');
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
		$stmt = $this->db->prepare('delete from admin where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}

}
