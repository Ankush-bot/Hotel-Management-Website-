<?php session_start();
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

if ($con === null) {
  die('Database connection failed');
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['register'])) {
    // Gather user inputs
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $dob = $_POST['dob'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    // Validation (you can add more validation rules as needed)
    if (empty($uname) || empty($email) || empty($phone) || empty($address) || empty($pincode) || empty($dob) || empty($pass) || empty($cpass)) {
        // Handle empty fields error
        echo "Please fill in all the fields.";
    } elseif ($pass !== $cpass) {
        // Handle password mismatch error
        echo "<script>alert('Passwords do not match.');</script>";
      //  alert('error','Passwords do not match.');
    } else {
      
        $frm_data = filteration($_POST);
        $query = "INSERT INTO `register`(`name`, `email`, `phn`, `address`, `pincode`, `dob`, `password`, `cpassword`) VALUES (?,?,?,?,?,?,?,?)";
        $values = [$frm_data['uname'],$frm_data['email'],$frm_data['phone'],$frm_data['address'],$frm_data['pincode'],$frm_data['dob'],$frm_data['pass'],$frm_data['cpass']];
        $res = select($query,$values,"ssisisss");  
    }
}

$contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
?>

<nav id="nav-bar"class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
<div class="container-fluid">
<a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">MK Hotel</a>
<button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item">
  <a class="nav-link me-2" href="index.php">Home</a>
</li>
<li class="nav-item">
  <a class="nav-link me-2" href="rooms.php">Rooms</a>
</li>
<li class="nav-item">
  <a class="nav-link me-2" href="facilities.php">Facilities</a>
</li>
<li class="nav-item">
  <a class="nav-link me-2" href="contact.php">Contact us</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="about.php">About</a>
</li>
</ul>
<div class="d-flex">
<button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
Login
</button>
<button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
Register
</button> 
</div>
</div>
</div>
</nav>


<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5 class="modal-title d-flex align-items-center">
<i class="bi bi-person-circle fs-3 me-2"></i>User Login
</h5>
<button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="mb-3">
<label class="form-label">Email address</label>
<input name="email" required type="email" class="form-control shadow-none">
</div>
<div class="mb-4">
<label class="form-label">Password</label>
<input name="password" required type="password" class="form-control shadow-none">
</div>
<div class="d-flex align-items-center justify-content-between mb-2">
<button name="login" type="submit" class="btn btn-dark shadow-none">LOGIN</button>
</div>
</div>
</form>
</div>
</div>
</div>




<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5 class="modal-title d-flex align-items-center">
<i class="bi bi-person-lines-fill fs-3 me-2"></i>User Registration</h5>
<button name="register" type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
Note: Your details must match with your ID (Adhaar card, Passport, Driving license, etc.) 
that will be required check-in.
</span>
<div class="container-fluid">
<div class="row">
<div class="col-md-6 ps-0 mb-3">
    <label class="form-label">Name</label>
<input name="uname" required type="text" class="form-control shadow-none">
</div>
<div class="col-md-6 p-0 mb-3">
    <label class="form-label">Email</label>
<input name="email" required type="email" class="form-control shadow-none">
</div>
<div class="col-md-6 ps-0 mb-3">
    <label class="form-label">Phone No</label>
<input name="phone" required type="number" class="form-control shadow-none">
</div>

<div class="col-md-12 p-0 mb-3">
    <label class="form-label">Address</label>
<textarea name="address" required class="form-control shadow-none" rows="1"></textarea>
</div>
<div class="col-md-6 ps-0 mb-3">
    <label class="form-label">Pincode</label>
<input name="pincode" required type="number" class="form-control shadow-none">
</div>
<div class="col-md-6 p-0 mb-3">
    <label class="form-label">Date of birth</label>
<input name="dob" required type="date" class="form-control shadow-none">
</div>
<div class="col-md-6 ps-0 mb-3">
    <label class="form-label">Password</label>
<input name="pass" required type="password" class="form-control shadow-none">
</div>
<div class="col-md-6 p-0 mb-3">
    <label class="form-label">Confirm Password</label>
<input name="cpass" required type="password" class="form-control shadow-none">
</div>
</div>
</div>
<div class="text-center my-1">

<button name="register" type="submit" class="btn btn-dark shadow-none">REGISTER</button>
</div>

<?php


// if((isset($_SESSION['email']) && $_SESSION['email']==true)){
//   redirect('admin/dashboard.php');
// }

if(isset($_POST['login']))
{
    $frm_data = filteration($_POST);

    $query = "SELECT * FROM `register` WHERE `email`=? AND `password`=?";
    $values = [$frm_data['email'],$frm_data['password']];

 $res = select($query,$values,"ss");
 //print_r($res);
if($res->num_rows==1){
    $row = mysqli_fetch_assoc($res);
    $_SESSION['email'] = true;
   // $_SESSION['adminId'] = $row['sr_no'];
     redirect('user_rooms.php');
}
else{
  // alert('error','Login failed - Invalid Credentials!');
  echo "<script>alert('Login failed - Invalid Credentials!');</script>";
}
}
?>


</div>
</form>
</div>
</div>
</div>