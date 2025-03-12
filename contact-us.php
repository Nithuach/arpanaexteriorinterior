<?php
include "captcha.php";
$success = false;
$failed = "";
$error = "";
$mobilenoerr = "";
$captchaerror = "";

$name = $email = $mobileno = $message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) { 

    if (
        isset($_POST['fullname']) && 
        isset($_POST['email']) && 
        isset($_POST['phone']) && 
        isset($_POST['message']) && 
        isset($_POST['captcha'])
      
    ) {
      if (isset($_POST['fullname']) && preg_match('/^[a-zA-Z]+$/', $_POST['fullname'])) {
        $name = $_POST['fullname'];
      } else {
          $nameerr = "Invalid name";
      }

      if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $email = $_POST['email'];
      } else {
        $emailerr = "Invalid Email address";
      }
    
      if(($_POST['phone']) && preg_match('/^\d+$/', $_POST['phone'])){
        $mobileno = $_POST['phone'];
      }
      else{
        $mobilenoerr = "Invalid mobile number";
      }

        $name = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);
        $submittedCaptcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
        $generatedCaptcha = $_SESSION['captcha'];

        if ($submittedCaptcha != $generatedCaptcha) {
            $captchaerror = "Invalid captcha";
            $name = htmlspecialchars($_POST['fullname']);
            $email = htmlspecialchars($_POST['email']);
            $mobileno =($_POST['phone']);
            $message = htmlspecialchars($_POST['message']);
            $_SESSION['captcha'] = generateCaptcha(); 
        }
        elseif (!$error && !$nameerr && !$mobilenoerr && !$emailerr && !$captchaerror) {
            $to = 'anithin271@gmail.com';
            $subject = 'Contact Us Form';
            $mailBody = "Details:\nName: $name\nEmail: $email\nMobile No.: $mobileno\nMessage: $message\n";
            $headers = 'From: ' . $email . "\r\n" .
                'Reply-To: ' . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Attempt to send the email
            $mailSent = mail($to, $subject, $mailBody, $headers);
        
            if ($mailSent) {
                // Clear form data
                $name = $email = $mobileno = $message = "";
                $_SESSION['form_submitted'] = true;
                header("Location: " . $_SERVER['REQUEST_URI']); 
                exit();
               
            } else {
                $failed = "Mail not sent please try again";
            }
        }
    } else {
        $error = "Invalid Details";
    }
    } else {
 $_SESSION['captcha'] = generateCaptcha();
}
?>

<script>
    setTimeout(function() {
        document.getElementById('successMessage').style.display = 'none';
        document.getElementById('failMessage').style.display = 'none';
        document.getElementById('errormesssages').style.display = 'none';
        document.getElementById('captchaError').style.display = 'none';
        document.getElementById('nameerr').style.display = 'none';
        document.getElementById('mobilenoerr').style.display = 'none';
        document.getElementById('emailerr').style.display = 'none';

    }, 5000); // 5 seconds for display error msg
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let formSubmitted = <?php echo json_encode( $_SESSION['form_submitted'] ); ?>;
        let captchaerror = <?php echo json_encode( $captchaerror ); ?>;
        let error = <?php echo json_encode( $error ); ?>;
        let failed = <?php echo json_encode( $failed ); ?>;
        let nameerr = <?php echo json_encode($nameerr ); ?>;
        let emailerr = <?php echo json_encode($emailerr ); ?>;
        let mobilenoerr = <?php echo json_encode($mobilenoerr ); ?>;

        if (formSubmitted || captchaerror || failed || error || nameerr || emailerr || mobilenoerr ) {
            document.getElementById("form-section").scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arpana Exteriors | Contact Us</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="images/logo/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <!-- NAVIGATION :: BEGIN -->
<div class="nav-top">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="top-left-social">
          <ul>
            <li><i class="bi bi-instagram"></i></li>
            <li><i class="bi bi-facebook"></i></li>
            <li><i class="bi bi-whatsapp"></i></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 cols-tr mt-lg-0 mt-3">
             <div class="top-right">
          <ul>
            <li><a href="">Email Us</a>  /</li>
            <li><a href="">Call Us</a>  /</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="nav-bottom">
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
          <a href="/">
        <div class="logo">
          <img src="images/logo/logo.png" alt="Logo" class="w-100">
        </div>
      </a>
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              About Us
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="/about-us">About Us</a></li>
              <li><a class="dropdown-item" href="/who-we-are">Who We Are</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/gallery">Gallery</a>
          </li>
          <li class="nav-item me-0">
            <a class="nav-link" href="/contact-us">Contact Us</a>
          </li>
        </ul>

      </div>
    </div>
  </nav>
</div>
<!-- NAVIGATION :: END -->

<!-- SUB HEADING :: BEGIN -->
<div class="subheading-wrap contactus-sub">
  <div class="container">
    <div class="subheading-content text-center">
        <h3 class="mb-1">Contact Us </h3>
    </div>
  </div>
</div>
<!-- SUB HEADING :: END -->


<!-- CONTACT US :: BEGIN -->
<div class="contactus-wrap">
  <div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3882.2595943312676!2d74.73150637833226!3d13.334121453536113!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbcbb9aabe4f5a1%3A0x423424567bef4469!2sArpana%20Interiors%20%26%20Exteriors!5e0!3m2!1sen!2sin!4v1740306632920!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <div class="contact-form">
    <div class="main-head">
      <h3 class="mb-2">Contact Us</h3>
      <p class="mb-4">We’d love to hear from you! Whether you have a project in mind, need expert advice, or want to collaborate, our team is here to assist you </p>
    </div>
    <div class="contactform-content">
      <div class="row">
        <div class="col-lg-4 mb-4">
          <div class="q-form">
            <div class="q-form-icon">
              <i class="bi bi-telephone-fill"></i>
            </div>
            <p>+91 7892417610</p>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="q-form">
            <div class="q-form-icon">
              <i class="bi bi-envelope-fill"></i>
            </div>
            <p>test@gmail.com</p>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="q-form">
            <div class="q-form-icon">
              <i class="bi bi-geo-fill"></i>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur </p>
          </div>
        </div>
      </div>
      <form method="post" id="form-section">
        <div id="successMessage" <?php if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) { echo 'style="display:block"'; unset($_SESSION['form_submitted']); } else { echo 'style="display:none"'; } ?>>
            Contact Us Form submitted successfully.
        </div>
        <div id="failMessage" class="errorMesssage" <?php if ($failed) echo 'style="display:block"'; else echo 'style="display:none"'; ?>>
          <?php echo $failed; ?>
        </div>
        <div id="errormesssages" class="errorMesssage" <?php if ($error) echo 'style="display:block"'; else echo 'style="display:none"'; ?>>
          <?php echo $error; ?>
        </div>

        <div id="nameerr" class="errorMesssage" <?php if ($nameerr) echo 'style="display:block"'; else echo 'style="display:none"'; ?>>
          <?php echo $nameerr; ?>
        </div>

        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Name</label>
          <input type="text" name="fullname" class="form-control" id="name" aria-describedby="emailHelp" value="<?php echo isset($name) ? $name: ''; ?>" required>
        </div>

        <div id="emailerr" class="errorMesssage" <?php if ($emailerr) echo 'style="display:block"'; else echo 'style="display:none"'; ?>>
          <?php echo $emailerr; ?>
        </div>

        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?php echo isset($email) ? $email:''; ?>" required>
        </div>
        <div id="mobilenoerr" class="errorMesssage" <?php if ($mobilenoerr) echo 'style="display:block"'; else echo 'style="display:none"'; ?>>
          <?php echo $mobilenoerr; ?>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Phone Number</label>
          <input type="tel" name="phone" class="form-control" id="phone" aria-describedby="emailHelp" value="<?php echo isset($mobileno) ? $mobileno:''; ?>" required>
        </div>
        <div class="mb-3">
          <label for="exampleTextarea" class="form-label">Comments</label>
          <textarea class="form-control" name="message"  id="message" rows="3" placeholder="Enter your message here..." required><?php echo isset($message) ? $message: ''; ?></textarea>
        </div>
        <div id="captchaError" class="errorMesssage"<?php if ($captchaerror) echo 'style="display:block"'; else echo 'style="display:none"'; ?>><?php echo $captchaerror; ?></div>
        <div class="mb-3 captcha-wrap">
          <div class="captcha-number">
            <span class="captcha" id="captchaContainer"><p class="mb-0"><?php echo  $_SESSION['captcha']; ?></p></span>
            <div class="captcha-ref me-2 ms-2" name="refresh" id="refreshCaptcha"> 
              <div class="refresh-btn"><img src="images/refresh.png" alt="Refresh" srcset="" class="w-100"></div>
            </div>
          </div>
          <input type="text"  name="captcha" id="cap-input" class="form-control cap-input">
        </div>
        <button type="submit" name="submit" class="submit-btn">Submit</button>
      </form>
      <ul class="footer-social mt-4">
        <li><i class="bi bi-instagram"></i></li>
        <li><i class="bi bi-facebook"></i></li>
        <li><i class="bi bi-whatsapp"></i></li>
      </ul>
    </div>
  </div>
</div>
<!-- CONTACT US :: END -->

<!-- FOOTER :: BEGIN -->
<div class="footer-wrap">
  <div class="container">
    <a href="/">
      <div class="footer-logo mb-3 text-center">
        <img src="images/logo/logo.png" alt="" class="w-50">
      </div>
    </a>
    <div class="row">
      <!-- About Section -->
      <div class="col-lg-4 col-md-6 text-center text-lg-start">
        <div class="footer-logo-text mt-3">
          <p>Aarpana Exterior And Interior, where we embody excellence, quality, and trust. Since 2012, we have been crafting global excellence with our products.</p>
        </div>
        <ul class="footer-social d-flex justify-content-center justify-content-lg-start">
          <li><i class="bi bi-instagram"></i></li>
          <li><i class="bi bi-facebook"></i></li>
          <li><i class="bi bi-whatsapp"></i></li>
        </ul>
      </div>
      
      <!-- Quick Links Section -->
      <div class="col-lg-4 col-md-6 text-center text-lg-start">
        <div class="footer-link-head mt-3">
          <h5>Quick Links</h5>
        </div>
        <ul class="footer-link">
          <li><a href="/about-us">About Us</a></li>
          <li><a href="/who-we-are">Who We Are</a></li>
          <li><a href="/gallery">Gallery</a></li>
          <li><a href="/contact-us">Contact Us</a></li>
        </ul>
      </div>
      
      <!-- Contact Section -->
      <div class="col-lg-4 text-center text-lg-start">
        <div class="footer-link-head mt-3">
          <h5>Contact Us</h5>
        </div>
        <ul class="footer-address">
          <li><i class="bi bi-telephone"></i><p>+91 9876543210</p></li>
          <li><i class="bi bi-envelope"></i><p>test@gmail.com</p></li>
          <li><i class="bi bi-geo-alt-fill"></i><p>Lorem ipsum dolor sit amet, consectetur.</p></li>
        </ul>
      </div>
    </div>
    <hr class="white-hr">
    <p class="text-center copyright-txt">Copyright © 2025 Aarpana Exterior And Interior | Website by <a href="https://www.linkedin.com/in/nithin-acharya-0102ab284" target="_blank"><i class="fab fa-linkedin"></i></a></p>
  </div>
</div>
<!-- FOOTER :: END -->

<script>
   document.getElementById('refreshCaptcha').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'captcha.php?action=generateCaptcha', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('captchaContainer').innerText = xhr.responseText;
        }
    };
    xhr.send();
});
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="js/script.js"></script>
<script>
  $(document).ready(function(){
    $('.your-slider-class').slick({
      dots: false,
      infinite: true,
      speed: 500,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: true,
      prevArrow: '<i class="bi bi-arrow-left-square left-arrow"></i>',
      nextArrow: '<i class="bi bi-arrow-right-square right-arrow"></i>',
    });
  });
</script>
<script>
  $(document).ready(function(){
    $('.testimonial-slider').slick({
      dots: false,
      infinite: true,
      speed: 500,
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: true,
      prevArrow: '<i class="bi bi-chevron-double-left testimonial-left-arrow"></i>',
      nextArrow: '<i class="bi bi-chevron-double-right testimonial-right-arrow"></i>',
      responsive: [
        {
          breakpoint: 1024, // Screens smaller than 1024px
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            arrows: true
          }
        },
        {
          breakpoint: 768, // Screens smaller than 768px
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true
          }
        },
        {
          breakpoint: 480, // Screens smaller than 480px
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true
          }
        }
      ]
    });
  });
</script>
</body>
</html>
