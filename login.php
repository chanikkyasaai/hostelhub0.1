<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hostelhub';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userType = $_POST['user-type'];
  $userid = $_POST['userid'];
  $password = $_POST['password'];

  
  $query = "";
  switch ($userType) {

    
      case 'student':
        $query = "SELECT * FROM users WHERE userid = ?";
        break;
      case 'store':
        $query = "SELECT * FROM storeadminusers WHERE userid = ?";
        break;
      case 'laundry':
        $query = "SELECT * FROM laundryadminusers WHERE userid = ?";
        break;
      case 'rc':
        $query = "SELECT * FROM rc WHERE userid = ?";
        break;
      case 'adminH':
        $query = "SELECT * FROM adminH WHERE userid = ?";
        break;
      case 'adminC':
        $query = "SELECT * FROM adminC WHERE userid = ?";
        break;
      default:
        $error = "Invalid user type";
        break;
    
  }

  if (!empty($query)) {
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, 's', $userid);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        
        if (password_verify($password, $hashedPassword) || strtolower($password) === strtolower($hashedPassword)) {
         
          session_start();
          $_SESSION['userid'] = $userid; 

          switch ($userType) {
            
            case 'student':
              header("Location: index.php");
              exit();
            case 'store':
              header("Location: storeadmin.php");
              exit();
            case 'laundry':
              header("Location: laundryadmin.php");
              exit();
            case 'rc':
              header("Location: rc.html");
              exit();
            case 'adminH':
              header("Location: admin.php");
              exit();
            case 'adminC':
              header("Location: adminC.html");
              exit();
          }
        } else {
          $error = "User ID or password is incorrect.";
        }
      } else {
        $error = "User ID or password is incorrect.";
      }
    } else {
      $error = "Query preparation failed: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
  } else {
    $error = "Invalid user type";
  }
}


mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MIT Hostels Website</title>
  <link rel="icon" type="image/png" href="HOSTELHUB.png">

  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;1,900&family=Space+Mono&family=Zeyada&display=swap" rel="stylesheet">
  <style>
  
    body {
      font-family: 'Exo', sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
    }

  
    header {
      background-color: #333333;
      color: #fff;
      padding: 20px;
      text-align: center;
    }


    nav {
      position: fixed;
      top: 75px;
      left: -250px;
      bottom: 0;
      width: 250px;
      background-color: #333;
      color: #fff;
      transition: left 0.3s;
      z-index: 999;
      overflow-y: auto;
    }

    nav.active {
      left: 0;
    }

    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      background-color: #333;
    }

    nav ul li {
      margin-right: 10px;
    }

    nav ul li a {
      display: block;
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      background-color: #222;
      transition: background-color 0.3s;
    }

    nav ul li a:hover {
      background-color: #555;
    }

    nav ul ul {
      display: none;
    }

    nav ul li:hover>ul {
      display: block;
    }

   
    #menu-icon {
      display: block;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 999;
      font-size: 24px;
      background: none;
      border: none;
      color: #fff;
      cursor: pointer;
      transition: transform 0.3s;
    }

    #menu-icon:hover {
      transform: scale(1.2);
    }

 
    section {
      margin: 20px 0;
      padding: 20px;
      background-color: #f4f4f4;
      border-radius: 5px;
    }

    section h2 {
      margin: 0 0 10px;
    }


    footer {
      background-color: #333;
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    footer p {
      margin: 0;
    }

    .login-form-container {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 300px;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 5px;
      text-align: center;
      z-index: 999;
      backdrop-filter: blur(8px);
      pointer-events: none;
    }

    .login-form-container.active {
      display: block;
      pointer-events: auto;
    }

    .login-form-container h2 {
      margin-bottom: 20px;
      font-family: 'Exo', sans-serif;
    }

    .login-form-container input[type="text"],
    .login-form-container input[type="password"],
    .login-form-container select {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-family: 'Exo', sans-serif;
    }

    .login-form-container input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #333;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      font-family: 'Exo', sans-serif;
    }

    .login-form-container input[type="submit"]:hover {
      background-color: #555;
    }

    .close-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      color: #555;
      cursor: pointer;
      transition: color 0.3s;
    }

    .close-icon:hover {
      color: #333;
    }

    .blur-background {
      filter: blur(8px);
      pointer-events: none;
    }
  </style>
</head>

<body>
  <header>
    <h1>HOSTELHUB</h1>
    <button id="menu-icon">&#9776;</button>
  </header>

  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li>
        <a href="#">Hostels</a>
        <ul class="submenu">
          <li><a href="#">VAIGAI HOSTEL (BLOCK - I)</a></li>
          <li><a href="#">RAJAM HOSTEL (BLOCK - II)</a></li>
          <li><a href="#">BIRLA HOSTEL (BLOCK - III)</a></li>
          <li><a href="#">AMARAVATHY HOSTEL (BLOCK - IV)</a></li>
          <li><a href="#">BHAVANI HOSTEL (BLOCK - V)</a></li>
          <li><a href="#">THAMIRABARANI HOSTEL (BLOCK - VI)</a></li>
          <li><a href="#">CAUVERY HOSTEL (BLOCK - VII)</a></li>
          <li><a href="#">MARUTHAM HOSTEL (BLOCK - VIII)</a></li>
          <li><a href="#">PONNI HOSTEL (BLOCK - IX)</a></li>
          <li><a href="#">NRI HOSTEL BOYS</a></li>
        </ul>
      </li>
      <li><a href="#">Facilities</a></li>
      <li><a href="#">Events</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#" onclick="toggleLoginForm()">Login</a></li>
    </ul>
  </nav>

  <section class="container">
    <h2>About MIT Hostels</h2>
    <p>Welcome to the official website of MIT Hostels. We provide comfortable and convenient accommodation for MIT
      students. Explore our hostels, facilities, and upcoming events. Contact us for any inquiries.</p>
  </section>
  <div class="login-form-container active" id="login-form-container">
    <i class="close-icon" onclick="toggleLoginForm()">&times;</i>
    <h2>Login</h2>
    <?php if (isset($error)): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form id="login-form" action="login.php" method="POST">
      <p>
        <select id="user-type" name="user-type" required>
          <option value="">Select User Type</option>
          <option value="student">Student</option>
          <option value="store">Store</option>
          <option value="laundry">Laundry</option>
          <option value="rc">RC</option>
          <option value="adminH">AdminH</option>
          <option value="adminC">AdminC</option>
        </select>
      </p>
      <p>
        <input type="text" id="userid" name="userid" placeholder="User ID" required>
      </p>
      <p>
        <input type="password" id="password" name="password" placeholder="Password" required>
      </p>
      <p>
        <input type="submit" id="login" value="Login">
      </p>
    </form>
  </div>
  
  <div id="blur-background" class="blur-background"></div>

  <footer>
    <p>&copy; 2023 MIT Hostels. All rights reserved. | Website by HostelHub</p>
  </footer>

  <script>
    function toggleLoginForm() {
      const loginFormContainer = document.getElementById('login-form-container');
      const blurBackground = document.getElementById('blur-background');
      loginFormContainer.classList.toggle('active');
      blurBackground.classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
      const menuIcon = document.getElementById('menu-icon');
      const nav = document.querySelector('nav');
      const submenuItems = document.querySelectorAll('nav ul li ul.submenu');

      menuIcon.addEventListener('click', function () {
        nav.classList.toggle('active');
      });

      submenuItems.forEach(function (submenu) {
        const parentLink = submenu.parentNode.querySelector('a');
        parentLink.addEventListener('click', function (event) {
          event.preventDefault();
          submenu.classList.toggle('active');
        });
      });
    });
  </script>
</body>

</html>