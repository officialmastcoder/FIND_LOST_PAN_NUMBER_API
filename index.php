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
require('database.php');
$message = "";
if(isset($_POST['name']) && $_POST['aadhaar_no'] && $_POST['dob'] ){
  // getting values
  $name = mysqli_real_escape_string($ahk_conn,$_POST['name']);
  $dob = mysqli_real_escape_string($ahk_conn,$_POST['dob']);
  $aadhaar = mysqli_real_escape_string($ahk_conn,$_POST['aadhaar_no']);
  $admin_secret = mysqli_real_escape_string($ahk_conn,$_POST['admin_secret']);
  
  if(password_verify($admin_secret,$main_secret)==true){
      $ack = "AHK". time().rand(111111,999999);
      $application_no = base64_encode($ack); // Base 64 Encoded Application Number
      $apiname = base64_encode($name); // Base 64 Encoded Customer Name
      $aadhaar_no = base64_encode($aadhaar); // Base 64 Encoded Aadhaar Number
      $apidob = base64_encode($dob); // Base 64 Encoded Date of birth
      $ret_wp_no = base64_encode("4554"); // Base 64 Encoded Retailer Whatsaap Number
      $callback_url = base64_encode("545"); // Base 64 Encoded Webhook URL / CallBack URL
      
      $url = 'https://api.apizone.in/v1/services/pan_no/submit.php?application_no='.$application_no.'&name='.$apiname.'&aadhaar_no='.$aadhaar_no.'&dob='.$apidob.'&ret_wp_no='.$ret_wp_no.'&api_key='.$api_key.'&callback_url='.$callback_url;
      
      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
      ));
      $response = curl_exec($curl);
      curl_close($curl);
          $response;
      $resdata = json_decode($response,true);
      if($resdata['status']=='1'){
        $date = date('d-m-Y');
        $insert = mysqli_query($ahk_conn,"INSERT INTO `panfind`(`application_no`, `name`, `aadhaar_no`, `dob`, `pan_no`, `status`, `date`) VALUES ('$ack','$name','$aadhaar','$dob','','pending','$date')");
        if($insert){
          $message = "<p style='color:green;font-weight:bold;'>".$resdata['message'] . " Ack no : " . $resdata['application_no']."</p>";
        }
      }else{
        $message = "<p style='color:red;font-weight:bold;'> ".$resdata['message']."</p>";
      }
  }else{
    $message = "<p style='color:red;font-weight:bold;'>Admin Secret Is Invalid! Please Enter Valid Admin Secret!</p>";
  }
  

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pan Find Page</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

</head>
<body>
<section class="w-100 p-4">
      <!-- Section: Design Block -->
      <section class="background-radial-gradient overflow-hidden">
        <style>
          .background-radial-gradient {
            background-color: hsl(218, 41%, 15%);
            background-image: radial-gradient(650px circle at 0% 0%,
                hsl(218, 41%, 35%) 15%,
                hsl(218, 41%, 30%) 35%,
                hsl(218, 41%, 20%) 75%,
                hsl(218, 41%, 19%) 80%,
                transparent 100%),
              radial-gradient(1250px circle at 100% 100%,
                hsl(218, 41%, 45%) 15%,
                hsl(218, 41%, 30%) 35%,
                hsl(218, 41%, 20%) 75%,
                hsl(218, 41%, 19%) 80%,
                transparent 100%);
          }

          #radius-shape-1 {
            height: 220px;
            width: 220px;
            top: -60px;
            left: -130px;
            background: radial-gradient(#44006b, #ad1fff);
            overflow: hidden;
          }

          #radius-shape-2 {
            border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
            bottom: -60px;
            right: -110px;
            width: 300px;
            height: 300px;
            background: radial-gradient(#44006b, #ad1fff);
            overflow: hidden;
          }

          .bg-glass {
            background-color: hsla(0, 0%, 100%, 0.9) !important;
            backdrop-filter: saturate(200%) blur(25px);
          }
        </style>

        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
          <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
              <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                Find Lost Pan Number <br>
                <span style="color: hsl(218, 81%, 75%)">With Powerful API</span>
              </h1>
              <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                Disclaimer: This API Portal Does not 'store' any data like name, email, aadhaar number, phone And dob we only Store Application Number for Track The Data from main Server.
              </p>
            </div>

            <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
              <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
              <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

              <div class="card bg-glass">
                <div class="card-body px-4 py-5 px-md-5">
                  <form method="POST" action="">
                    <div class="row">
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input type="number" id="form3Example1" class="form-control" name="aadhaar_no" placeholder="Aadhaar Number"  required>
                          <label class="form-label" for="form3Example1" style="margin-left: 0px;">Aadhaar Number</label>
                        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68.8px;"></div><div class="form-notch-trailing"></div></div></div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input required type="text" id="form3Example2" class="form-control" name="name" placeholder="Full Name Here">
                          <label class="form-label" for="form3Example2" style="margin-left: 0px;">Full Name</label>
                        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68px;"></div><div class="form-notch-trailing"></div></div></div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input required type="date" id="form3Example1" class="form-control" name="dob" placeholder="30/12/1999">
                          <label class="form-label" for="form3Example1" style="margin-left: 0px;">Date of Birth</label>
                        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68.8px;"></div><div class="form-notch-trailing"></div></div></div>
                      </div>

                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input required type="password" id="form3Example1" class="form-control" name="admin_secret" placeholder="Enter Admin Secret">
                          <label class="form-label" for="form3Example1" style="margin-left: 0px;">Admin Secret</label>
                        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68.8px;"></div><div class="form-notch-trailing"></div></div></div>
                      </div>

                      
                    </div>

                    <div class="row">
                      <div class="form-outline">
                        <?php echo ($message!="")?  $message : ''; ?>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">
                      Submit
                    </button>

                    
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Section: Design Block -->

    </section>

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>