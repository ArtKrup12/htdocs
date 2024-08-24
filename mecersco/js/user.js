let hamburger_btn = document.querySelector('.hamburger_menu');
let info_btn = document.querySelector('#info_toggle');
let logout_btn = document.querySelector('.logout_active');

hamburger_btn.addEventListener('click', function() {
    document.querySelector('.hamburger_menu_list').classList.toggle('toggle_display');
});

info_btn.addEventListener('click', function() {
    document.querySelector('.info_menu_list').classList.toggle('toggle_display');
});

logout_btn.addEventListener('click', function(){
    document.querySelector('.logout_btn').classList.toggle('active');
});


// const Toast = Swal.mixin({
//     toast: true,
//     position: 'top-end',
//     showConfirmButton: false,
//     timerProgressBar: true,
//     timer: 1000,
// })

// function confirm(){
//     Swal.fire({
//         title: 'คุณแน่ใจใช่ไหมว่าต้องการยืนยัน?',
//         text: "หากยืนยันแล้วจะไม่สามารถย้อนกลับได้!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'ใช่, ฉันยืนยัน!'
//       }).then((result) => {
//         if (result.isConfirmed) {
//           Swal.fire(
//             'เรียบร้อยแล้ว!',
//             'ทำรายการเรียบร้อย! กรุณรอผู้มีสิทธิ์อนุมัติยืนยันให้คุณ.',
//             'success'
//           )
//         }
//       })
// }

function selected(){
    Toast.fire({
        icon: 'success',
        title: 'เพิ่มเรียบร้อย!'
    })
}

