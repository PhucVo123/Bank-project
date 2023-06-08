<?php
require_once './connect.php';
header('Connect-Type: application/json; charset = utf-8');

if($_SERVER['REQUEST_METHOD'] !='GET')
{
    http_response_code(405);
    die(json_encode(array('code' => 405 ,'message' => 'API này chỉ hỗ trợ GET')));
}
$input = json_decode(file_get_contents('php://input'));
if(is_null($input)){
    die(json_encode(array('code'=>2,'message'=>'Chỉ hỗ trợ JSON')));
}
if(!property_exists($input,'dayTransfer') ){
    http_response_code(400);
    die(json_encode(array('code'=>1,'message'=>'Thiếu dữ liệu đầu vào')));
}
if(empty($input->dayTransfer)){
    die(json_encode(array('code'=>1,'message'=>'Thông tin không hợp lệ')));
}
if(show_detail($conn,$input)['code'] != 0)
{
    die(json_encode(array('code' => 1, 'message' => show_detail($conn,$input)['message'])));
}

echo json_encode(array('code' => 0, 'data' => show_detail($conn,$input)['data'])) ;
?>