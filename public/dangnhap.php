<?php

if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}

require_once __DIR__ . '/../bootstrap.php';


use CT271\Labs\admin;
use CT271\Labs\user;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_db = new user($PDO);
    $user_formdbs = $user_db->all();
    $user_2 = new user($PDO);
    $user_dangnhap = $user_2->fill($_POST);
    foreach ($user_formdbs as $user_formdb) :
        if (($user_formdb->email == $user_dangnhap->email) && ($user_formdb->pass_word) ==  $user_dangnhap->pass_word) {
            $_SESSION['user_formdb'] = 'me';
            $_SESSION['id'] = $user_formdb->id;// id_kh
            $_SESSION['email'] = $user_formdb->email;
            $_SESSION['pass_word'] = $user_formdb->pass_word;
            $_SESSION['full_name'] = $user_formdb->full_name;
            redirect('menu.php');
           }   
    endforeach;
    
    

    $admin_db = new admin($PDO);
    $admin_formdbs = $admin_db->all();
    $admin_2 = new admin($PDO);
    $admin_dangnhap = $admin_2->fill($_POST);
    foreach ($admin_formdbs as $admin_formdb) :
        if (($admin_formdb->email == $admin_dangnhap->email) && $admin_formdb->pass_word == $admin_dangnhap->pass_word) {
        $_SESSION['admin_formdb'] = 'admin';
        $_SESSION['email'] = $admin_formdb->email;
        $_SESSION['pass_word'] = $admin_formdb->pass_word;
       $_SESSION['full_name'] = $admin_formdb->full_name;
        redirect('quantri.php');
       }    
    endforeach;
}

include_once __DIR__ . '/../partials/header.php'; //header

?>

<section class="container-fluid bg" style="background-color: #FFFFFF;">
   
        <div class="container py-3 my-5">
            <div class="row justify-content-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="border-0 shadow" style="width: 430px;">
                        <div class="p-4">
                            <form id="form" method="post">
                                <h3 class="text-center">ĐĂNG NHẬP</h3>

                                <div class="form-group mb-3 pt-2">
                                    <input type="text" class="form-control" id="email" name="email"  placeholder="Nhập vào email">
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" id="pass_word" name="pass_word"  placeholder="Nhập vào số mật khẩu">
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-cart">Đăng nhập</button>
                                    <a href="">Quên mật khẩu?</a></span>
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
