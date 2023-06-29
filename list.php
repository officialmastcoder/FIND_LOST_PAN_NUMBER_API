<?php
/**
 * License : GPL (General Public License).
 * Author: AHK WEB SOLUTIONS
 * Company : AHK WEB SOLUTIONS
 * Author-email : admin@ahkwebsolutions.com
 * Author-contact: +1 5395001134
 * Project Name: FIND LOST PAN NUMBER USING API
 * Api Url : https://apizone.in
 */
include('database.php');
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pan Find LIST Page</title>
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    </head>
    <body>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Application No </th>
                <th scope="col">Name</th>
                <th scope="col">Aadhaar No</th>
                <th scope="col">PAN No</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
<?php
$res = mysqli_query($ahk_conn,"select * from panfind ");
if(mysqli_num_rows($res)>0){
    $sl=1;
    while($row= mysqli_fetch_assoc($res)) {
        ?>
            
            <tr>
                    <th scope="row"><?php echo $sl; ?></th>
                    <td><?php echo $row['application_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['aadhaar_no']; ?></td>
                    <td <?php echo ($row['status']=='success')? "class='text-success' style='font-weight:bold;'": ''; ?>><?php echo $row['pan_no']; ?></td>
                    <td><?php 
                    if($row['status']=='success'){
                        echo "Success";
                    }else if($row['status']=='refunded'){
                        echo "Refunded to API";
                    }else{
                        echo "Data Processing Please Wait";
                    }
                    ?></td>
                    </tr>    
        <?php
        $sl ++;
    }
}


?>

    </tbody>
</table>
<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>