<?php
require_once __DIR__ . '/../bootstrap.php';
use CT271\Labs\product;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Xóa giỏ hàng
if (isset($_SESSION['carts'])) {
    if (isset($_GET['xoaall'])) {
        // Xóa toàn bộ giỏ hàng
        unset($_SESSION['carts']);
    } elseif (isset($_GET['xoa'])) {
        foreach ($_SESSION['carts'] as $key => $values) {
            if ($values['id'] == $_GET['xoa']) {
                unset($_SESSION['carts'][$key]);
                $_SESSION["carts"] = array_values($_SESSION["carts"]);
                break;
            }
        }
    }
    header("Location: giohang.php");
}

// cộng số lượng sản phẩm
if(isset($_SESSION['carts'])&&isset($_GET['cong'])){
    foreach($_SESSION['carts'] as &$cart ) {
        if($cart['id'] == $_GET['cong'] && $cart['so_luong']<10) {
            $cart['so_luong'] += 1;
            break;
        }
    }
    header("Location:giohang.php");
}

// trừ số lượng sản phẩm
if(isset($_SESSION['carts'])&&isset($_GET['tru'])){
    foreach($_SESSION['carts'] as &$cart) {
        if($cart['id'] == $_GET['tru'] && $cart['so_luong']>1) {
            $cart['so_luong'] -= 1;
            break;
        }
    }
    header("Location:giohang.php");
}


// 
if(isset($_SESSION['carts'])&&isset($_GET['thanhtoan'])){
    foreach($_SESSION['carts'] as $key=>$values){
            unset($_SESSION['carts'][$key]);
            
    }
    $_SESSION["carts"] = array_values($_SESSION["carts"]);
    header("Location:giohang.php");
} 





if(isset($_POST['themgiohang'])) {
// session_destroy();
    $id = $_GET['id'];
    $quantity = 1;
    $product = new product($PDO);
    $row = $product->have_id($id);

    if($row) {
        $add_cart = array(
            'id' => $id,
            'ten' => $row[0]->product_name,
            'so_luong' => $quantity,
            'gia' => $row[0]->price,
            'hinh' => $row[0]->img
        );

        if(isset($_SESSION['carts'])) {
            $found = false;

            foreach($_SESSION['carts'] as &$cart) {
                if($cart['id'] == $id) {
                    $cart['so_luong'] += 1;
                    $found = true;
                }
            }

            if(!$found) {
                $_SESSION['carts'][] = $add_cart;
            }
        } else {
            $_SESSION['carts'][] = $add_cart;
        }
    }

    //print_r($_SESSION['carts']);
    $previous_url = $_SERVER['HTTP_REFERER'];

    header("Location:$previous_url");

}



?>