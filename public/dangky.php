<?php 

require_once __DIR__ . '/../bootstrap.php';


if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}

use CT271\Labs\user;

$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = new user($PDO);
	$user->fill($_POST);
	if ($user->validate()) {
		if($user->save()){
            $message = "Bạn đã đăng ký thành công";
            $alertClass = 'alert-success';
        }
	} else {
        $message = "Bạn đã đăng ký không thành công";
        $alertClass = 'alert-danger';
    }

    // làm rỗng các trường sao khi đăng ký thành công
    $_POST['full_name'] = '';
    $_POST['email'] = '';
    $_POST['place'] = '';
    $_POST['phone'] = '';
    $_POST['pass_word'] = '';

	$errors = $user->getValidationErrors();
}

include_once __DIR__ . '/../partials/header.php'; //header
?>
<?php if (isset($message)) : ?>
    <!-- nếu có lỗi thì hiện thông báo lỗi -->
    <div class="alert <?= $alertClass ?>">
        <?= $message ?>
    </div> 
<?php endif ?>

<section class="container-fluid" style="background-color: #ffffff;">
        <div class="container py-3 my-5">
            <div class="row justify-content-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="border-0 shadow" style="width: 430px;">
                        <div class="p-4">
                            <form method="post" novalidate>
                                <h3 class="text-center">ĐĂNG KÝ</h3>
                                
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control<?= isset($errors['full_name']) ? ' is-invalid' : '' ?>" id="full_name" name="full_name" value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>" placeholder="Nhập vào họ tên" >

                                    <?php if (isset($errors['full_name'])) : ?>
                                        <span class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['full_name']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" placeholder="Nhập vào email">

                                    <?php if (isset($errors['email'])) : ?>
                                        <span class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['email']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" class="form-control<?= isset($errors['place']) ? ' is-invalid' : '' ?>" id="place" name="place" value="<?= isset($_POST['place']) ? htmlspecialchars($_POST['place']) : '' ?>" placeholder="Nhập vào địa chỉ">
                                    
                                    <?php if (isset($errors['place'])) : ?>
                                        <span class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['place']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>" id="phone" name="phone" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>" placeholder="Nhập vào số điện thoại">

                                    <?php if (isset($errors['phone'])) : ?>
                                        <span class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['phone']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" class="form-control<?= isset($errors['pass_word']) ? ' is-invalid' : '' ?>" id="pass_word" name="pass_word" value="<?= isset($_POST['pass_word']) ? htmlspecialchars($_POST['pass_word']) : '' ?>" placeholder="Nhập vào số mật khẩu">

                                    <?php if (isset($errors['pass_word'])) : ?>
                                        <span class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['pass_word']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" id="comfirm_password" name="comfirm_password" placeholder="Nhập lại mật khẩu">
                                </div>

                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="check">
                                    <label class="form-check-label" for="exampleCheck1">Bạn chấp nhận <a href="#">điều khoản & chính sách</a> của chúng tôi</label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-cart">Đăng Ký</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- footer -->
<?php include __DIR__ . '/../partials/footer.php' ?> 


