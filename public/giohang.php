<?php 

require_once __DIR__ . '/../bootstrap.php';


$total = 0;

if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}

if(isset($_SESSION['carts'])){
  $count = count($_SESSION['carts']);
}

include_once __DIR__ . '/../partials/header.php';
?>


<title>Giỏ Hàng</title>

<section>
        <div><img src="./uploads/banner-cart.png" alt="" class="w-100 d-block"></div>

        <div class="container-fluid">
            <div class="container py-5">
                <div class="rounded-2" style="width: 1295px; background-color: #ffff;">
                    <div class="card-body">
                        <div class="card-title">
                            <h4 class="card-title text-center">CHI TIẾT ĐƠN HÀNG</h4>
                        </div>
                        <hr>
                        
                        <table class="table table-warning text-center" style="border-color: #000;">
                          <thead>
                            <tr>
                              <th scope="col" class="col-width_1">STT</th>
                              <th scope="col" class="col-width_2">Tên SP</th>
                              <th scope="col" class="col-width_1">Giá</th>
                              <th scope="col" class="col-width_3">Hình SP</th>
                              <th scope="col" class="col-width_2">Số lượng</th>
                              <th scope="col" class="col-width_1">Hành động</th>
                            </tr>
                          </thead>
                          <tbody class="align-middle">
                            <?php $i = 1; ?>
                            <?php  if(isset($_SESSION['carts'])){
                                foreach($_SESSION['carts'] as $cart){
                                  $total+=($cart['so_luong']*$cart['gia']);
                            ?>
                              <tr>
                                <th scope="row"><?php echo $i++; ?></th>
                                <td><?=$cart['ten'] ?></td>
                                <td><?=number_format($cart['gia']*$cart['so_luong'], 0, ',', '.') ?>đ</td>
                                <td><img src="./uploads/<?=$cart['hinh'] ?>" alt="..." style="width: 100px;"></td>
                                <td>
                                  <div class="d-flex justify-content-center">
                                    <button class="m-2 border-0" style="background-color: #fff3cdff;">
                                      <a href="<?=BASE_URL_PATH."themgiohang.php?tru=".$cart['id']?>"><i class="fa-solid fa-minus"></i></a>
                                    </button>

                                    <input id="form1" min="0"  value="<?=$cart['so_luong']?>" type="" class="form-control" style="width: 60px;" />
                                    

                                    <button class="m-2 border-0" style="background-color: #fff3cdff;">
                                      <a href="<?=BASE_URL_PATH."themgiohang.php?cong=".$cart['id']?>"><i class="fa-solid fa-plus"></i></a>
                                    </button>
                                  </div>
                                </td>
                                <td>
                                  <button class="border-0" style="background-color: #fff3cdff;">
                                    <a href="<?=BASE_URL_PATH."themgiohang.php?xoa=".$cart['id']?>" style="color: #be1010; font-size: 1.5rem;"><i class="fa-solid fa-trash"></i></a>
                                  </button>
                                </td>
                              </tr>
                            <?php
                                }
                              }else{

                              }
                            ?>
                          </tbody>
                        </table>
                        <hr>

                        <div class="d-flex justify-content-end">
                          <span style="font-size: 20px; font-weight: 500; font-style: italic;">Tổng tiền = <?=number_format($total, 0, ',', '.')  ?>đ</span>
                        </div>

                        <div class="d-flex my-2 justify-content-center">
                          <div class="me-2">
                            <a href="<?=BASE_URL_PATH."themgiohang.php?xoaall=".$cart['id']?>" class="btn btn-danger">
                              <i class="fa-solid fa-xmark"></i> Hủy đơn hàng
                            </a>
                          </div>

                          <div>
                              <form id="form" action="themgiohang.php?thanhtoan=1" method="post">
                                <button class="btn btn-success" type="submit" >
                                  Hoàn tất đặt hàng
                                </button>
                              </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
  const form = document.querySelector('#form');

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    alert('Đặt hàng thành công!');
    form.submit();
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<?php include __DIR__ . '/../partials/footer.php' ?> 

