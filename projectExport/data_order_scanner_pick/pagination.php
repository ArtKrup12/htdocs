<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
include "../config.php";
if ($_POST['carton'] != 1) {
    $sql_select_check_carton2 = "SELECT * FROM draft_head WHERE sale_id= " . $_POST['sale_id'] . " AND assign_id=" . $_POST['assign_id'] . " AND sale_detail_id =" . $_POST['sale_detail_id'] . " ORDER BY draft_head_id DESC";
    $query_data_carton2 = $mysqli->query($sql_select_check_carton2);
    $data_row2 = $query_data_carton2->num_rows;
    $row2 = $query_data_carton2->fetch_assoc();
    ?>
    <input type="hidden" id="max_carton" value="<?php echo $data_row2; ?>">
    <?php
//    echo $row2['draft_head_id'];
    $id = $_POST['carton'];
} else {

    $sql_select_check_carton = "SELECT * FROM draft_head WHERE sale_id= " . $_POST['sale_id'] . " AND assign_id=" . $_POST['assign_id'] . " AND sale_detail_id =" . $_POST['sale_detail_id'];
    $query_data_carton = $mysqli->query($sql_select_check_carton);
    $data_row = $query_data_carton->num_rows;
    $id = null;
    if ($data_row > 0) {
        $row = $query_data_carton->fetch_assoc();
//        print_r($row);
        $id = $data_row;
    } else {
        $id = 1;
    }
}
?>
<input type="hidden" id="max_length" value="<?php echo $data_row ;?>">
    <nav aria-label="Page navigation example " style="display: flex; justify-content: center; align-items: center;">
        ลังที่ :&nbsp;
        <ul class="pagination">
            <li class="page-item black-cart" id="<?php echo $id - 1; ?>">
                <a class="page-link " aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link"><?php echo $id; ?></a></li>
            <li class="page-item next-cart" id="<?php echo $id + 1; ?>">
                <a class="page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
    $(document).ready(function () {
        $('.black-cart').click(function () {
            let data_id = $(this).attr('id')
            let max_page = $('#max_length').val
            if (data_id <= 0) {

            } else {
                console.log(data_id)
                $.ajax({
                    url: `data_order_scanner_pick/pagination.php`,
                    method: 'POST',
                    data: {carton: data_id, sale_detail_id: 2, sale_id: 3, assign_id: 7},
                    success: function (data) {
                        $('#show_pagination').html(data)
                    }
                });
            }

        })
        $('.next-cart').click(function () {
            let data_id = $(this).attr('id')
            let max_page = $('#max_length').val
            console.log(max_page)

            console.log(data_id-1+' : '+1)
            if (data_id-1 > 1) {

                console.log(max_page)
                if (data_id <= max_page) {

                } else {
                    $.ajax({
                        url: `data_order_scanner_pick/pagination.php`,
                        method: 'POST',
                        data: {carton: data_id, sale_detail_id: 7, sale_id: 2, assign_id: 3},
                        success: function (data) {
                            $('#show_pagination').html(data)
                        }
                    });

                }
            }else{
                console.log('test')
                $.ajax({
                    url: `data_order_scanner_pick/pagination.php`,
                    method: 'POST',
                    data: {carton: data_id, sale_detail_id: 7, sale_id: 2, assign_id: 3},
                    success: function (data) {
                        $('#show_pagination').html(data)
                    }
                });
            }
        })
    })


</script>
