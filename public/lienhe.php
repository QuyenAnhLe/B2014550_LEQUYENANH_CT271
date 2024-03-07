<?php 

require_once __DIR__ . '/../bootstrap.php';
include_once __DIR__ . '/../partials/header.php'; //header
?>


<title>Liên Hệ</title>
<section>

    <div><img src="./uploads/banner-header02.png" alt="" class="w-100 d-block"></div>

    <div class="container-fluid">
        <div class="container" style="padding-top: 50px; width: 1200px;">
            <p>
                Min Tea luôn mong muốn nhận được nhưng phản hồi quý giá của quý khách hàng để có cơ hội hoàn thiện sản phẩm, 
                dịch vụ hơn nữa. Những đóng góp của quý khách hàng luôn là tài sản vô giá đối với chúng tôi.
            </p>
            <hr style="margin-top: 22px; margin-bottom: 22px;">
            <form id="form" action="" method="post" novalidate>
                <div class="row">
                    <div class="form-group1 col-sm-6" style="margin-bottom: 15px;">
                    <input type="text" class="form-input" name="fullname" placeholder="Họ và tên" id="name">
                    <span class="form-message"></span>
                    </div>
                    <div class="form-group1 col-sm-6" style="margin-bottom: 15px;">
                    <input type="email" class="form-input" name="email" placeholder="Email" id="email">
                    <span class="form-message"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group1 col-sm-6" style="margin-bottom: 15px;">
                    <input type="tel" class="form-input" name="phone" placeholder="Số điện thoại" id="phone">
                    <span class="form-message"></span>
                    </div>
                    <div class="form-group1 col-sm-6" style="margin-bottom: 15px;">
                    <input type="tel" class="form-input" name="phone" placeholder="Địa chỉ" id="phone">
                    <span class="form-message"></span>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <p>Nội dung phản hồi</p>
                    <textarea class="form-control" name="feedback_content" id="feedback_content" cols="30" rows="10"></textarea>
                </div>

                <button type="submit" class="btn" style="margin-bottom: 15px; background-color: #F2B686; color: #fff;" >Gửi phản hồi</button>
            </form>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
      const username = document.querySelector('#name');
      const email = document.querySelector('#email');
      const phone = document.querySelector('#phone');
      const feedback = document.querySelector('#feedback_content');
      const form = document.querySelector('#form');

      // Hiển thị lỗi  
      function showError (input, message) {
            let parent = input.parentElement; //lấy ra phần tử cha của input 
            let formMessage = parent.querySelector('.form-message'); // lấy ra phần tử con có class form-message

            parent.classList.add('error'); // thêm lớp CSS "error" vào phần tử cha của iput
            parent.classList.remove('success'); // xóa lớp CSS "success" ra khỏi phần tử cha của input
            formMessage.innerText = message; 
        }

        // Hiển thị thành công
        function showSuccess (input) {
            let parent = input.parentElement;
            let formMessage = parent.querySelector('.form-message');

            parent.classList.remove('error');
            parent.classList.add('success');
            formMessage.innerText = '';
        }

        // Kiểm tra trường nhập rỗng
        function checkEmptyError(listInput) {
            let isEmptyError = false;
            listInput.forEach(input => {
                input.value = input.value.trim();

                if(!input.value) {          // nếu ô nhập rỗng thì thông báo lỗi
                    isEmptyError = true;
                    showError(input, 'Vui lòng nhập trường này');
                } else {
                    showSuccess(input);
                }
            });

            return isEmptyError;
        }

        // kiểm tra cú pháp email
        function checkEmail(input) {
            const regexEmail = 
            /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            input.value = input.value.trim();
            let isEmailEmpty = !input.value;
            let isEmailError = regexEmail.test(input.value);

            if(isEmailEmpty) {
                showError(input, 'Vui lòng nhập trường này');
            } else if (!isEmailError) {
                showError(input, 'Vui lòng nhập đúng cú pháp Email');
            } else {
                showSuccess(input);
            }

            return isEmailEmpty || !isEmailError;
        }

        // kiểm tra cú pháp sđt
        function checkPhone(input){
          const regexPhone = /(84|0[3|5|7|8|9])+([0-9]{8})\b/g;
          input.value = input.value.trim();
          let isPhoneEmpty = !input.value;
          let isPhoneError = regexPhone.test(input.value);

          if(isPhoneEmpty) {
              showError(input, 'Vui lòng nhập trường này');
          } else if (!isPhoneError) {
              showError(input, 'Vui lòng nhập đúng cú pháp số điện thoại');
          } else {
              showSuccess(input);
          }

          return isPhoneEmpty || isPhoneError;
        } 

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let isEmptyError = checkEmptyError([username, email, phone]);
            let isEmailError = checkEmail(email);
            let isPhoneError = checkPhone(phone);


            if (isEmptyError && isEmailError && isPhoneError) {
                 // Kiểm tra lỗi khi tất cả điều kiện đều đúng
                if (isEmptyError) {
                    username.focus();
                } else if (isEmailError) {
                    email.focus();
                } else if (isPhoneError) {
                    phone.focus();
                }
            } else {        
                username.value = '';
                email.value = '';
                phone.value = '';
                feedback.value = '';
                alert('Biểu mẫu phản hồi gửi thành công!');
            }
        });
</script>

<!-- footer -->
<?php include __DIR__ . '/../partials/footer.php' ?> 




