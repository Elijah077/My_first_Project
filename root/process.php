<?php 
include('config.php');

$errors = array();
foreach ($errors as $error) {
echo $errors;
}

if (isset($_POST['register_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
    // `userid`, `firstname`, `lastname`, `gender`, `id_type`, `id_number`, `phone`, `email`, `country`, `branch_id`, `physical_address`, `role`, `password`, `token`, `date_registered`, `account_status`
    $check = $dbh->query("SELECT email, phone FROM users WHERE (email='$email' OR phone = '$phone') ")->fetchColumn();
    if(!$check){
    $password = sha1($password);
    $firstname = addslashes($firstname);
    $lastname = addslashes($lastname);
    $gender = addslashes($gender);
    $email = addslashes($email);
    $phone = addslashes($phone);
    $physical_address = addslashes($physical_address);

    $sql = "INSERT INTO users VALUES(NULL,'$firstname','$lastname','$gender','$id_type','$id_number','$phone','$email','$country','$branch_id','$physical_address','$role','$password','','$today','Active')";
    $result = dbCreate($sql);
    if($result == 1){
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Registration is Successful, OTP sent to you via Email to complete registration process. <br>
            Check your <b>SPAM</b> mail for the <b>TOKEN</b></div>';
        $_SESSION['status'] = '<div id="note2" class="alert alert-success text-center">Registration is Successful, Redirecting to Login</div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:3; url=".SITE_URL);
    }else{
        $_SESSION['status'] = '<div id="note2" class="alert ramoney border border-danger text-center">
        Account  Address already registered
        </div>';
    }
    }else{
    $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">
        Email Address already registered
        </div>';
      // echo "<script>
      //   alert('Email Address already registered');
      //   window.location = '".SITE_URL."/register';
      //   </script>";
    }
    }
    }elseif (isset($_POST['verify'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
    $result = $dbh->query("SELECT * FROM users WHERE token = '$otp' AND email = '$email' " );
    if ($result->rowCount() == 1) {
        $dbh->query("UPDATE users SET account_status = 'Active' WHERE token = '$otp' AND email = '$email' ");
        $subj = "POST KAZI - Account Verification Successful";
        $body = "Hello {$email} your account is activated successfully.";
        GoMail($email,$subj,$body);
        $_SESSION['loader'] = '<center><div class="spinner-border text-center text-success"></div></center>';
        $_SESSION['status'] = '<div class="card card-body alert alert-success text-center">
        <strong>Account verified Successfully, Redirecting to Login...</strong></div>';
        header("refresh:2; url=login");
    }else{
        $_SESSION['status'] = '<div class="card card-body alert alert-warning text-center">
        Account Verification Failed., please check your Token and try again.</div>';
    }
}

}elseif (isset($_POST['login_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
    $password = sha1($password);
    $result = $dbh->query("SELECT * FROM users WHERE (email = '$uname' OR phone = '$uname') AND password = '$password' AND account_status = 'Active' ");
    $result1 = $dbh->query("SELECT * FROM users WHERE (email = '$uname' OR phone = '$uname') AND password = '$password' AND account_status = 'Pending' ");
    if ($result->rowCount() == 1) {
        $row = $result->fetch(PDO::FETCH_OBJ);
        //`userid`, `firstname`, `lastname`, `gender`, `id_type`, `id_number`, `phone`, `email`, `country`, `branch`, `physical_address`, `role`, `password`, `token`, `date_registered`
        $_SESSION['userid'] = $row->userid;
        $_SESSION['firstname'] = $row->firstname;
        $_SESSION['lastname'] = $row->lastname;
        $_SESSION['gender'] = $row->gender;
        $_SESSION['email'] = $row->email;
        $_SESSION['phone'] = $row->phone;
        $_SESSION['role'] = $row->role;
        $_SESSION['date_registered'] = $row->date_registered;  
        $_SESSION['status'] = '<div class=" card card-body alert ramoney text-center">
        Login Successful.</div>';
        $_SESSION['loader'] = '<center><div class="spinner-border text-center text-ramoney"></div></center>';
        header("refresh:1; url=".SITE_URL);
        
    }elseif ($result1->rowCount() == 1) {
        $token = rand(11111,99999);
        $dbh->query("UPDATE users SET token = '$token' WHERE email = '$email' ");
        $rx = dbRow("SELECT * FROM users WHERE email = '$email' ");
        $subj = "POST KAZI - Account Verification Token";
        $body = "Hello {$rx->fullname}, your account verification token is: <br>
            <h1><b>{$token}</b></h1>";
        GoMail($email,$subj,$body);
        $_SESSION['email'] = $email;
        $_SESSION['status'] = '<div class="alert alert-success text-center">Verification token is sent to your email successfully, Please enter the OTP send to you via Email to complete registration process</div>';
        header("refresh:3; url=".SITE_URL.'/token');
    }else{
        $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-warning text-center">
        Invalid account, Try again.</div>';
    }

    }else{
        $_SESSION['status'] = '<div id="note1" class="card card-body alert alert-danger text-center">
        Wrong Token inserted</div>';
    }
}elseif (isset($_POST['resent_token_btn'])) {
    trim(extract($_POST));
    if (count($errors) == 0) {
        $result = $dbh->query("SELECT * FROM users WHERE email = '$email' " );
        if ($result->rowCount() == 1) {
            $token = rand(11111,99999);
            $dbh->query("UPDATE users SET token = '$token' WHERE email = '$email' ");
            $rx = dbRow("SELECT * FROM users WHERE email = '$email' ");
            $subj = "POST KAZI - Account Verification Token";
            $body = "Hello {$rx->fullname} you account verification token is: <br>
                <h1><b>{$token}</b></h1>";
            GoMail($email,$subj,$body);
            $_SESSION['email'] = $email;
            $_SESSION['status'] = '<div class="alert alert-success text-center">Verification token is sent to your email successfully, Please enter the OTP send to you via Email to complete registration process</div>';
            header("refresh:3; url=".SITE_URL.'/token');
        }else{
            $_SESSION['status'] = '<div class="card card-body alert alert-warning text-center">
            Account Verification Failed., please check your Token and try again.</div>';
        }
    }
}elseif (isset($_POST['update_user_profile_btn'])) {
    trim(extract($_POST));
    $profile_desc = addslashes($profile_desc);
    $check = $dbh->query("SELECT userid FROM profile_about WHERE userid = '$userid' ")->fetchColumn();
    if (!$check) {
        $sql = $dbh->query("INSERT INTO profile_about VALUES(NULL,'$userid','$profile_desc') ");
        if ($sql) {
            $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Your profile is updated successfully!. </div>';
            // header("refresh: 2; url=profile");
        }else{
            $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">Error when updating user profile. Check and try again. </div>';
        }
    }else{
        $_SESSION['status'] = '<div id="note2" class="alert alert-danger text-center">You just correct, you just updated your profile now. </div>';
        // header("refresh:1; url=profile");
    }

}elseif (isset($_POST['update_user_personal_interest_btn'])) {
    trim(extract($_POST));
    $personal_job_interest = addslashes($personal_job_interest);
    $sql = $dbh->query("UPDATE users SET personal_job_interest = '$personal_job_interest' WHERE userid = '$userid' ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Your Profession is updated successfully!. </div>';
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Error Occured, sorry, our team is notified, shortly we going to work on it!. </div>';
    }
}elseif (isset($_POST['edit_update_user_profile_btn'])) {
    trim(extract($_POST));
    $sql = $dbh->query("UPDATE profile_about SET profile_desc = '$edit_profile_info' WHERE userid = '$userid' ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Profile info updated successfully!. </div>';
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Error Occured, sorry, our team is notified, shortly we going to work on it!. </div>'; 
    }
}elseif (isset($_POST['add_branch_btn'])) {
    trim(extract($_POST));
    $check = $dbh->query("SELECT branch_name FROM branches WHERE branch_name = '$branch_name' ")->fetchColumn(); 
    if (!$check) {
        $sql = $dbh->query("INSERT INTO branches VALUES(NULL, '$branch_name') ");
        if ($sql) {
            $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">New Branch added successfully. </div>';
            $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
            header("refresh:1; url=branches");
        }else{
            $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Branch saving failed. </div>';
        }
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-warning text-center">This branch already exist in the system. </div>';
    }
}elseif(isset($_POST['add_new_forex_rate_btn'])){
    //`forex_id`, `currency_from`, `currency_to`, `buying_rate`, `selling_rate`, `created_at`, `updated_at`
    trim(extract($_POST));
    $currency_from = addslashes($currency_from);
    $currency_to = addslashes($currency_to);
    $buying_rate = (float) str_replace(',', '', $buying_rate);
    $selling_rate = (float) str_replace(',', '', $selling_rate);
    $sql = $dbh->query("INSERT INTO forex VALUES(NULL, '$currency_from', '$currency_to','$buying_rate','$selling_rate','$today',NOW()) ");
    if ($sql) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Forex Rate detail is saved successfully. </div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:1; url=forex-rate");
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Forex Rate detail saving failed. </div>';
    }
}elseif (isset($_REQUEST['delete-talent'])) {
    $id = base64_decode($_GET['delete-talent']);
    $res = $dbh->query("DELETE FROM talent_doing WHERE wid = '$id' ");
    header("Location: ".SITE_URL.'/my-talent');

}elseif (isset($_POST['add_customer_btn'])) {
    trim(extract($_POST));
    // `customer_id`, `sender_name`, `receiver_name`, `transfer_method`, `sender_currency`, `sender_amount`, `receiver_currency`, `total_usd`, `receiver_amount`, `commission`, `added_by`, `customer_status`, `customer_date`
    $sender_name = addslashes($sender_name);
    $receiver_name = addslashes($receiver_name);
    $transfer_method = addslashes($transfer_method);
    $sender_currency = addslashes($sender_currency);
    $sender_amount = (float) str_replace(',', '', $sender_amount);
    $receiver_currency = addslashes($receiver_currency);
    $total_usd = str_replace(',', '', $total_usd);
    $receiver_amount = (float) str_replace(',', '', $receiver_amount);
    // $commission = (float) str_replace(',', '', $commission);
    $commission      = 0;  // No commission for now
    $result = $dbh->query("INSERT INTO customers VALUES(NULL,'$sender_name', '$receiver_name', '$transfer_method','$sender_currency','$sender_amount','$receiver_currency', '$total_usd', '$receiver_amount', '$commission', '$added_by','pending','$today')");
    if ($result) {
        $_SESSION['status'] = '<div id="note1" class="alert alert-success text-center">Customer Order taken successfully. </div>';
        $_SESSION['loader'] = '<center><div id="note1" class="spinner-border text-center text-success"></div></center>';
        header("refresh:1; url=customers");
    }else{
        $_SESSION['status'] = '<div id="note1" class="alert alert-danger text-center">Customer order failed. </div>';
    }
}

?>