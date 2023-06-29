<?php
include('database.php');

$res = mysqli_query($ahk_conn,"select * from panfind WHERE status='pending'");
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
            $pan_number = $response->pan_no;
            $update = mysqli_query($ahk_conn,"UPDATE panfind SET status='success', pan_no='$pan_number' WHERE id='".$row['id']."' ");
        }elseif($response->status =='900' || $response->status =='902' || $response->status =='800' || $response->status =='802' || $response->status =='905' ){
            $update = mysqli_query($ahk_conn,"UPDATE panfind SET status='refunded' WHERE id='".$row['id']."' ");
        }
    }
}



echo "CronJob Run Success";die;

?>