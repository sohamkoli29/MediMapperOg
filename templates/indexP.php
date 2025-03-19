<?php
include('../scripts/config.php');
session_start();

// Ensure the user is logged in as a doctor


// Fetch user profile picture
$user_id = $_SESSION['user_id']; // Use logged-in user's ID
$sql = "SELECT profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($profile_pic);
$stmt->fetch();
$stmt->close();
$conn->close();


$profile_pic_src = !empty($profile_pic) ? "$profile_pic" :"default.png"; // Use default image if none found
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMapper</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Darker+Grotesque:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Days+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body >
    <!--- Header -->
    <header>
    <!-- Hamburger Icon for Mobile -->
    <div class="hamburger" id="hamburger">
        <i class="fas fa-bars"></i> <!-- Font Awesome hamburger icon -->
    </div>

    <!-- Logo -->
    <div class="main-logo">
        <a href="#"> <img src="../asset/Logo.png" alt="main-logo"> </a>
    </div>

    <!-- NavLinks -->
    <div class="nav-link" id="nav-link">
        <!-- Home Button -->
        <a href="#home" class="nav-link-item">
            <div class="navBtn">
                <img src="../asset/home.png" alt="home-icon">
                <p>Home</p>
            </div>
        </a>
        <!-- Service Button -->
        <a href="#services" class="nav-link-item">
            <div class="navBtn">
                <img src="../asset/Service.png" alt="services-icon">
                <p>Services</p>
            </div>
        </a>
        <!-- About Button -->
        <a href="#about" class="nav-link-item">
            <div class="navBtn">
                <img src="../asset/about 1.png" alt="about-icon">
                <p>About</p>
            </div>
        </a>
        <!-- Doctor Button -->
        <a href="#ai-doctors" class="nav-link-item">
            <div class="navBtn">
                <img src="../asset/DocImg.png" alt="doctors-icon">
                <p>Ai Doctors</p>
            </div>
        </a>
        <!-- FAQ Button -->
        <a href="#faq" class="nav-link-item">
            <div class="navBtn">
                <img src="../asset/faqImg.png" alt="faq-icon">
                <p>FAQ</p>
            </div>
        </a>
        <!-- Contact Us Button -->
        <a href="#contact-us" class="nav-link-item">
            <div class="navBtn">
                <img src="../asset/contactUs.png" alt="contact-us">
                <p>Contact us</p>
            </div>
        </a>
    </div>

    <!-- My Profile Button -->
    <div class="myProfile">
        <a href="profile.php">
            <img src="<?php echo $profile_pic_src; ?>" alt="profile_pic">
            <p>My Profile</p>
        </a>
    </div>
</header>
    <!--HomeSection-->
    <section id="home">
        <h1 class="main-heading"><span class="head-white">MEDI</span> MAPPER</h1>    
    <div class="main-info">
        <h2>Smart Healthcare, Simplified</h2>
        </br>
        <h3> Instant doctor consultations, AI</br> health advice, and easy medicine</br> ordering—anytime, anywhere</h3>
    </div>
    <div class="home-right"><img src="../asset/doctorHome.png" alt="home-doctors"></div>
    </section>

    <!--AboutSection-->
    <section id="about">
        <div class="about-Head"><h1>ABOUT</h1></div>
        <div class="about-img"><img src="../asset/VCdoctor.png" alt="VCdoctor"></div>
        <div class="about-discription"><h5>We are here to make healthcare easy, affordable, and accessible <br> for all. Whether you want to speak with a doctor, ask a health<br> question, or order medicines, our platform will take care of <br>everything. From online consultations with doctors to rapid <br>health advice from our AI chatbot to getting prescriptions, all<br> without leaving home.<br><br>

            Our platform is made available in many languages, thereby being<br> easy and user-friendly even for slow internet areas. We are here <br>to support every step of emergency help and provide diagnostic <br>tests at an affordable rate.<br><br>
            
            Our goal is to bring quality healthcare to your fingertips, no <br>matter where you are.
            </h5></div>
    </section>


    <!--Services-->
    <section id="services">
        <div class="service-head"><h1>SERVICES</h1></div>
        <div class="service-cards">
            <a href="consultation.php">
                <div class="card">
                        
                <img src="../asset/consultationImg.png" alt="symptom-img">
                <h3>Consultation</h3>
            </div>
        </a>
            <a href="predict.php">

            <div class="card">
                <img src="../asset/symptomImg.png" alt="symptom-img">
                <h3>Symptom Mapper</h3>
            </div>
        </a>    
            <a href="report.php">
            <div class="card">     
            <img src="../asset/reportImg.png" alt="symptom-img">
            <h3>Report Analysis</h3>
            </div>
        </a>
            <a href="remedies.php">
            <div class="card">
            <img src="../asset/remediesImg.png" alt="symptom-img">
            <h3>Home Remedies</h3>
                </div>
        </a>
    
        <a href="delivery.php">
        <div class="card">
        <img src="../asset/DeliveryImg.png" alt="symptom-img">
        <h3>Medicine Delivery</h3>
        </div>
        </a>
        </div>
        </a>
    </section>


    <!--Doctor-->
    <section id="ai-doctors">
  <div class="section-header">
    <h2>AI Health Experts</h2>
    <p>Advanced healthcare solutions powered by artificial intelligence</p>
  </div>
    
  <div class="doctors-container">
    <!-- AI Medical Expert Card -->
    <div class="doctor-card">
      <div class="card-inner">
        <div class="card-front">
          <div class="doctor-img">
            <img src="../asset/aiMedicalExpert.jpg" alt="AI Medical Expert" />
          </div>
          <h3>AI Medical Expert</h3>
        </div>
        <div class="card-back">
          <h3>AI Medical Expert</h3>
          <p>Advanced diagnostics and personalized treatment recommendations based on the latest medical research.</p>
         <a href="MedicalExpert.php"> <button class="consult-btn">Chat Now</button></a>
        </div>
      </div>
    </div>
    
    <!-- AI Ayurvedic Expert Card -->
    <div class="doctor-card">
      <div class="card-inner">
        <div class="card-front">
          <div class="doctor-img">
            <img src="../asset/aiAyurvedicExpert.jpg" alt="AI Ayurvedic Expert" />
          </div>
          <h3>AI Ayurvedic Expert</h3>
        </div>
        <div class="card-back">
          <h3>AI Ayurvedic Expert</h3>
          <p>Holistic health solutions based on ancient Ayurvedic principles combined with modern medical knowledge.</p>
         <a href="AyurvedicExpert.php"> <button class="consult-btn">Chat Now</button></a>
        </div>
      </div>
    </div>
    
    <!-- AI Nutritionist Card -->
    <div class="doctor-card">
      <div class="card-inner">
        <div class="card-front">
          <div class="doctor-img">
            <img src="../asset/aiNutritionExpert.jpg" alt="AI Nutritionist/Dietitian" />
          </div>
          <h3>AI Nutritionist/Dietitian</h3>
        </div>
        <div class="card-back">
          <h3>AI Nutritionist/Dietitian</h3>
          <p>Personalized nutrition plans and dietary guidance for optimal health and specific health conditions.</p>
            <a href="NutritionistExpert.php"> <button class="consult-btn">Chat Now</button> </a>
        </div>
      </div>
    </div>
    
    <!-- AI Mental Health Counselor Card -->
    <div class="doctor-card">
      <div class="card-inner">
        <div class="card-front">
          <div class="doctor-img">
            <img src="../asset/aiMentalExpert.jpg" alt="AI Mental Health Counselor" />
          </div>
          <h3>AI Mental Health Counselor</h3>
        </div>
        <div class="card-back">
          <h3>AI Mental Health Counselor</h3>
          <p>Supportive counseling and evidence-based strategies for mental wellbeing and emotional health.</p>
          <a href="MentalExpert.php"><button class="consult-btn">Chat Now</button> </a>
        </div>
      </div>
    </div>
  </div>
</section>



    <!--FAQ-->
    <section id="faq">
        <div class="faq-head"><h1>Frequently Ask Question</h1></div>
        <div class="questionsBox">
            <div class="question">
                <p>What is MediMapper?</p>
                <button><div class="smb">+</div></button>
            </div>
            <div class="ans"><p>MediMapper is a healthcare platform that helps users identify </br> 
                potential diseases based on symptoms. It also connects patients </br>
                 with doctors for consultations via chat and video calls.</p></div>
        </div>
        <form action="" method="post" >
            <div class="faqForm">
            <img src="../asset/faq.png" alt="normal logo" >

            <h1>Any Question</h1>
            <p>You can ask anything you want to know about medimapper</p>
            <label >let me know :</label>
            <input type="text" placeholder="type here" name="faq" class="faqinput">
            <button type="submit">Send</button>
        </div>
        </form>
    </section>
    

    <!-- Contact Us Section -->
<section id="contact-us">
    <div class="contact-head"><h1>Contact Us</h1></div>
    <div class="contact-form">
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Enter your message" rows="5" required></textarea>
            </div>
            <button type="submit" class="submit-button">Send Message</button>
        </form>
    </div>
</section>

<footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h4>HealthPortal</h4>
                    <p>Your comprehensive healthcare companion for symptom checking, remedies, and medical report analysis.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="symptom_checker.php">Symptom Mapper</a></li>
                        <li><a href="remedies.php">Home Remedies</a></li>
                        <li><a href="consultations.php">Doctor Consultations</a></li>
                        <li><a href="report_analysis.php">Report Analysis</a></li>
                        <li><a href="chatbot.php">Health Chatbot</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="help.php">Help Center</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                        <li><a href="terms.php">Terms of Service</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="faq.php">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Health Street, Medical City</li>
                        <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-envelope"></i> support@healthportal.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                &copy; 2025 MediMapper [Team CodeMates]. All rights reserved.
            </div>
        </div>  
    </footer>
</body>
<script src="../scripts/script.js"></script>



</html>