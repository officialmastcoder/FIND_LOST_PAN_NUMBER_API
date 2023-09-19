<?php
/**
 * License : GPL (General Public License).
 * Author: AHK WEB SOLUTIONS
 * Company : AHK WEB SOLUTIONS
 * Author-email : admin@ahkwebsolutions.com
 * Author-contact: +1 5395001134
 * Project Name: FIND LOST PAN NUMBER USING API
 * Api Url : https://apizone.in
 * ===================================================
 * =================================================== 
 * This is a Cron job file 
 * Add this to your cron job in your hosting provider
 * 
 * =========
 * Hostinger Setup 
 * https://hpanel.hostinger.com/hosting/yourodmain/advanced/cron-jobs
 * go to this path and set cron 
 * cron command is given  below 
 * ========
 * command==
 * 
 * curl https://yourodmian/script/cron.php
 * 
 * make sure it's running in every 5 min interval 
 * 
 */
include('database.php');

$res = mysqli_query($ahk_conn,"select * from panfind WHERE status='pending' LIMIT 10");
if(mysqli_num_rows($res)>0){
    $sl=1;
    while($row= mysqli_fetch_assoc($res)) {
    
        $application_no = $row['application_no'];
        $application_no = base64_encode($application_no);
        $api_key = $api_key;
        $url = "https://api.apizone.in/v1/services/pan_no/track.php?application_no=$application_no&api_key=$api_key";
        
        $result = file_get_contents($url);
        $response = json_decode($result);
        // echo "<pre>"; print_r($response);die;
        if($response->status =='1'){
            // update pan number in database
            $pan_number = $response->pan_no;
            $update = mysqli_query($ahk_conn,"UPDATE panfind SET status='success', pan_no='$pan_number' WHERE id='".$row['id']."' ");
        }elseif($response->status =='900' || $response->status =='902' || $response->status =='800' || $response->status =='802' || $response->status =='905' ){
            // set refund if refunded
            $update = mysqli_query($ahk_conn,"UPDATE panfind SET status='refunded' WHERE id='".$row['id']."' ");
        }
    }
}



echo "CronJob Run Success";die;

?>