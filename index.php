<?php
session_start();
// Redirect the User to the users.php page if the user is already logged in
if (isset($_SESSION['unique_id'])) {
  header("location:users.php");
}

include_once('header.php');
?>


<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Chat App</header>
      <form action="#" method="POST" enctype="multipart/form-data">
        <div class="error-text"></div>

        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name" required>
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
        </div>

        <div class="field input">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <i class="fa-solid fa-eye"></i>
        </div>

        <div class="field image">
          <label>Select Image</label>
          <input type="file" name="image" accept="image/x-png,image/jpeg,image/jpg,image/gif" required>
        </div>

        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>

        <div class="link">Already Signed Up? <a href="login.php">Login Now</a></div>
      </form>
    </section>
  </div>

  <script src="script/show_hide_password.js"></script>
  <script src="script/signup.js"></script>
</body>

</html>