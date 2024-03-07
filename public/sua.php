<?php
require_once __DIR__ .  '/../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
  }

  
use CT271\Labs\category;
use CT271\Labs\product;

$product = new product($PDO);
$category = new category($PDO);
$categorys = $category->all();

$id = isset($_REQUEST['id']) ?
	filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;


if ($id < 0 || !($product->find($id))) {
	redirect(BASE_URL_PATH);
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($product->update($_POST, $_FILES)) {
		// Cập nhật dữ liệu thành công
		redirect('quantri.php');
	}
	// Cập nhật dữ liệu không thành công
	$errors = $product->getValidationErrors();
}

include_once __DIR__ .  '/../partials/header.php';
?>


<section>
    <div class="container-fluid" style="background-color: #fff;">
        <div class="container py-5">
            <div class="mb-3">
                <h5>
                    <a href="index.php" style="text-decoration: none; color:#000;" >Trang Chủ</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <a href="quantri.php" style="text-decoration: none; color:#000;">Admin</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <a href="them.php" style="text-decoration: none; color:#bfbfbf;">Chỉnh sửa Sản Phẩm</a>
                </h5>
            </div>
            <div class="rounded-2" style="width: 1295px; background-color: #D4ECF4; color: #000;">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="card-title text-center">CHỈNH SỬA SẢN PHẨM</h4>
                    </div>
                    <hr>
                    <div class="row justify-content-center">
                        <form name="frm" id="frm" action="" method="post" class="col-sm-6" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="<?= htmlspecialchars($product->getId()) ?>">
			                <input type="hidden" name="category_id" value="<?= htmlspecialchars($product->category_name) ?>">

                            <!-- Name -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="product_name">Tên sản phẩm</label>
                                <input type="text" name="product_name" class="form-control<?= isset($errors['product_name']) ? ' is-invalid' : '' ?>" maxlen="255" id="product_name" placeholder="Nhập tên sản phẩm..." value="<?= isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '' ?>" />

                                <?php if (isset($errors['product_name'])) : ?>
                                    <span class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['product_name']) ?></strong>
                                    </span>
                                <?php endif ?>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"  for="price">Giá sản phẩm</label>
                                <input type="number" min="0" name="price" class="form-control <?= isset($errors['price']) ? ' is-invalid' : '' ?>" maxlen="255" id="phone" placeholder="Nhập giá sản phẩm..." value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>" >

                                <?php if (isset($errors['price'])) : ?>
                                    <div class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['price']) ?></strong>
                                    </div>
                                <?php endif ?>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"  for="img">Hình ảnh</label>
                                <input type="file" name="img" class="form-control <?= isset($errors['img']) ? ' is-invalid' : '' ?>" maxlen="255" id="img" placeholder="Nhập hình ảnh sản phẩm..." value="<?= isset($_POST['img']) ? htmlspecialchars($_POST['img']) : '' ?>">

                                <?php if (isset($errors['img'])) : ?>
                                    <div class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['img']) ?></strong>
                                    </div>
                                <?php endif ?>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label"  for="category">Loại sản phẩm</label>
                                <select name="category_id" class="form-control">
                                    <?php foreach ($categorys as $category) : ?>
                                            <option value=" <?= $category->category_id ?>"> <?= $category->category_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label"  for="quantity">Số lượng</label>

                                <input type="number" min="1" name="quantity" class="form-control <?= isset($errors['quantity']) ? ' is-invalid' : '' ?>" maxlen="255" id="quantity" placeholder="Nhập số lượng sản phẩm... " value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>">
                                <?php if (isset($errors['quantity'])) : ?>
                                    <div class="invalid-feedback">
                                        <strong><?= htmlspecialchars($errors['quantity']) ?></strong>
                                    </div>
                                <?php endif ?>
                            </div>

                            <!-- Submit -->
                            <br>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<?php include_once __DIR__ . '/../partials/footer.php' ?>