<?php 

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once('../../init/initialization.php');

$d = new DateTime();

$data = array();

$members = new Members();

$member_id = htmlentities($_POST['member_id']);

$current_member = $members->find_by_id($member_id);
	
if(!$current_member){
    $data['message'] = "errorMember";
    echo json_encode($data);
    die();
}

$roles = new Roles();
$current_role = $roles->find_by_id($_POST['role_id']);
	
if(!$current_role){
    $data['message'] = "errorRole";
    echo json_encode($data);
    die();
}

$members->id = $current_member['id'];
$members->role_id = $current_role['id'];
$members->fullnames = $current_member['fullnames'];
$members->image = $current_member['image'];
$members->phone = $current_member['phone'];
$members->email = $current_member['email'];
$members->dob = $current_member['dob'];
$members->gender = $current_member['gender'];
$members->location = $current_member['location'];
$members->status = $current_member['status'];
$members->username = $current_member['username'];
$members->forgot_code = $current_member['forgot_code'];
$members->created_date = $current_member['created_date'];
$members->edited_date = $d->format("Y-m-d H:i:s");

if($members->update()){
    $data['message'] = "success";
}

echo json_encode($data);