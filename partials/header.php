<?php 
require_once '../bootstrap.php';

use CT271\Labs\product;
use CT271\Labs\category;

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}


$category = new category($PDO);
$categorys = $category->all();

if(isset($_SESSION['carts'])){
  $count = count($_SESSION['carts']);
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/css/main.css">

    <!-- font-icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  </head>
  <body>
    <header>
      <div class="main-header">
        <nav class="navbar navbar-expand-lg">
          <div class="container">
            <a class="navbar-brand" href="#">
              <img class="img-logo" src="uploads/Min_Tea-removebg-preview.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <div class="ms-auto d-flex align-items-center">
                <form class="d-flex" action="sanpham.php">
                  <input class="form-search px-2" type="text" id="search" name="search" value="<?php if(isset($_GET['search'])){ echo($_GET['search']);}?>" placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                  <button class="btn0" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </button>
                </form>

                <div class="icon-header_cart mx-4">
                  <a href="giohang.php">
                    <i class="cart-icon fa-solid fa-cart-shopping"></i>
                    <span class="header__cart-notice">
                      <?php if(isset($count)){
                        echo $count;
                      }  else{echo 0;} ?> 
                    </span>
                  </a>
                </div>
                
               
                 <?php if(isset($_SESSION['full_name'])) : ?>
                    <div class="dropdown ms-3">
                        <a class="item-header_user dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: #F2B686;">
                            <i class="fa-regular fa-user"></i> <?php echo $_SESSION['full_name'] ?>
                        </a>
                    
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width: 8rem;">
                            <li>
                                <form action="<?= BASE_URL_PATH . 'dangxuat.php' ?>" method="post">
                                    <input type="submit" class="btn btn-danger btn-block mx-3" value="Đăng Xuất">
                                </form>
                            </li>
                        </ul>
                    </div>
                  <?php else: ?>
                    <div class="item-header_user ms-3">
                        <a href="dangky.php" style="text-decoration: none; color: #F2B686;">Đăng ký</a>
                    </div>
                    <div class="item-header_user ms-3">
                        <a href="dangnhap.php" style="text-decoration: none; color: #F2B686;">Đăng nhập</a>
                    </div>
                  <?php endif?>
                
              </div>
            </div>
          </div>
        </nav>
      </div>
      
      <div class="cover-header">  
        <nav class="cover-header_nav navbar-light">
            <div class="container">
              <ul class="nav justify-content-center">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="index.php">TRANG CHỦ</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="sanpham.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    THỨC UỐNG
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php foreach($categorys as $category) : ?>
                      <li>
                        <a class="dropdown-item" href="<?= BASE_URL_PATH ."sanpham.php?id=".$category->getId()?>" value="<?= $category->getId() ?>">
                          <?= $category->category_name ?>
                        </a>
                      </li>
                    <?php endforeach ?>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="gioithieu.php">GIỚI THIỆU</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="lienhe.php">LIÊN HỆ</a>
                </li>
              </ul>
            </div>
        </nav>
      </div>
    </header>
