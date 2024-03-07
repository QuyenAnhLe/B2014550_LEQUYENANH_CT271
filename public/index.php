<?php 


require_once __DIR__ . '/../bootstrap.php';

use CT271\Labs\product;
use CT271\Labs\category;

$product = new product($PDO);
$products = $product->all();
$category = new category($PDO);
$categorys = $category->all();

include_once __DIR__ . '/../partials/header.php'; //header
?>

<!-- section home page -->
<title>Trang Chủ</title>

<section>
    <div><img src="./uploads/bia-1.png" alt="" class="w-100 d-block"></div>
      
    <div class="container-fluid">
        <div class="container">
            <h3 class="text-center" style="padding: 15px 0; text-shadow: 2px 2px 5px #f4ad73; color: #f6a254;">MENU THỨC UỐNG</h3>
          
            <div class="row py-2">
                <?php foreach ($products as $product) : ?>
                    <div class="col-sm-4">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <div class="product">
                                        <img class="img-fluid rounded-start" src="uploads/<?= $product->img ?>" alt="..." >
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $product->product_name ?></h5>
                                        <p class="card-text"  style="font-size: 1.2rem;"><?=number_format($product->price, 0, ',', '.')?>đ</p>
                                        <p class="card-text"><small class="text-muted">Hương vị thơm ngon</small></p>

                                        <form action="themgiohang.php?id=<?= $product->getId() ?>" method="POST">
                                            <div class="d-flex">
                                                <input type="submit" name="themgiohang" value="Đặt ngay" class="btn btn-cart mt-auto">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
    </div>
 </section>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- footer -->
<?php include __DIR__ . '/../partials/footer.php' ?> 














