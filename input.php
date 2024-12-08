<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search with ID</title>
    <style>
        /* สไตล์รายการ */
        .search-container {
            position: relative; /* ใช้ relative เพื่อให้ .list-items วางตัวอยู่ภายใน container นี้ */
        }

        .list-items {
            display: none;
            position: absolute; /* ทำให้ list อยู่ด้านล่าง search */
            top: 100%; /* แสดงด้านล่าง input */
            left: 0;
            border: 1px solid #ddd;
            background-color: white;
            z-index: 999; /* วางทับองค์ประกอบอื่น */
            max-height: 150px; /* กำหนดความสูงสูงสุด */
            overflow-y: auto; /* เลื่อนดูได้ถ้าข้อความยาว */
            white-space: nowrap; /* ไม่ให้ข้อความขึ้นบรรทัดใหม่ */
        }

        .list-items li {
            padding: 8px;
            list-style: none;
            cursor: pointer;
        }

        .list-items li:hover {
            background-color: #f1f1f1;
        }

        input[type="text"] {
            width: 100%; /* ให้ input มีขนาดเต็ม */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="search-container">
    <input type="text" id="searchInput" placeholder="ค้นหา...">
    <ul class="list-items" id="itemList">
        <li data-id="1">Apple</li>
        <li data-id="2">Banana</li>
        <li data-id="3">Orange</li>
        <li data-id="4">Grapes</li>
        <li data-id="5">Pineapple</li>
        <li data-id="6">Mango</li>
    </ul>
</div>

<script>
    $(document).ready(function(){
        // เมื่อมีการพิมพ์ใน input
        $('#searchInput').on('keyup', function(){
            var value = $(this).val().toLowerCase();
            if(value) {
                // แสดงรายการ
                $('#itemList').show();
            } else {
                // ซ่อนรายการเมื่อไม่มีการพิมพ์
                $('#itemList').hide();
            }
            
            // กรองรายการที่ตรงกับข้อความที่พิมพ์
            $('#itemList li').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // ซ่อนรายการเมื่อคลิกที่ตัวเลือก และ log ค่า id ที่เลือก
        $('#itemList li').on('click', function() {
            var selectedText = $(this).text();
            var selectedId = $(this).data('id'); // ดึงค่า id จาก data-id

            $('#searchInput').val(selectedText);
            $('#itemList').hide();
            
            // Log ค่าที่เลือกใน console
            console.log('คุณเลือก: ' + selectedText + ', ID: ' + selectedId);
        });
    });
</script>

</body>
</html>
