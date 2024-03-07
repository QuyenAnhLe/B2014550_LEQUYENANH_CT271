<?php
require_once __DIR__ . '/../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}


use CT271\Labs\product;
$product = new product($PDO); // khoi tao de sd cac ham
$products = $product->all();

include_once __DIR__ . '/../partials/header.php';
?>


<section>
    <div class="container-fluid" style="background-color: #fff;">
        <div class="container py-5">
            <div class="mb-3" style="padding-left: 12px;">
                <h5>
                    <a href="index.php" style="text-decoration: none; color:#000;" >Trang Chủ</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <a href="quantri.php" style="text-decoration: none; color:#bfbfbf;">Admin</a>
                </h5>
            </div>
            <div class="rounded-2" style="width: 1295px; background-color: #ffff;">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="card-title text-center font-weight-bold" style="color: #fcae39;">DANH MỤC SẢN PHẨM</h3>
                    </div>
                    <hr>

                    <div class="my-2">
                        <a href="<?= BASE_URL_PATH . 'them.php' ?>" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Thêm sản phẩm
                        </a>
                    </div>

                    <table class="table table-warning text-center" style="border-color: #000;">
                        <thead>
                            <tr>
                                <th scope="col" class="col-width_1">STT</th>
                                <th scope="col" class="col-width_3">Tên SP</th>
                                <th scope="col" class="col-width_2">Giá</th>
                                <th scope="col" class="col-width_3">Hình SP</th>
                                <th scope="col" class="col-width_2">Loại SP</th>
                                <th scope="col" class="col-width_2">Số lượng</th>
                                <th scope="col">Ngày nhập</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php $i = 1; ?>
                            <?php foreach ($products as $product) :  ?>
                                <tr>
                                    <th scope="row"><?php echo $i++; ?></th>
                                    <td><?= htmlspecialchars($product->product_name) ?></td>
                                    <td><?= htmlspecialchars(number_format($product->price, 0, ',', '.')) . 'đ' ?></td>
                                    <td><img style="width: 100px;" src="uploads/<?=$product->img ?>" alt="..." /></td>
                                    <td>
                                        <?php
                                            if ($product->category_id == 1) {
                                                echo ("TRÀ SỮA");
                                            } if ($product->category_id == 2) {
                                                echo ("TRÀ NGUYÊN CHẤT");
                                            } else if ($product->category_id == 3) {
                                                echo ("TRÀ TRÁI CÂY");
                                            }
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($product->quantity) ?></td>
                                    <td><?= date("d-m-Y", strtotime($product->ngay_nhap)) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL_PATH . 'sua.php?id=' . $product->getId() ?>" class="btn btn-xs btn-warning">
                                            <i alt="Edit" class="fa fa-pencil"> Edit</i>
                                        </a>
                                        <form class="delete" action="<?= BASE_URL_PATH . 'xoa.php' ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= $product->getId() ?>">
                                            <button type="button" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $product->getId() ?>">
                                                <i alt="Delete" class="fa fa-trash"> Delete</i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?= $product->getId() ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body ">
                                                            Bạn có chắc muốn xóa sản phẩm <span class="h5 text-danger"><?php echo $product->product_name . ' ?'  ?> </span> 
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-primary">Xóa</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<?php include __DIR__ . '/../partials/footer.php' ?> 