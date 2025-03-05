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
</head>

<body >
    <!--- Header -->
    <header >
       <!-- Logo-->
        <div class="main-logo"><a href="#"> <img src="../asset/Logo.png" alt="main-logo"> </a></div> 

        <!--NavLinks-->
        <div class="nav-link">
            <!--homeBtn-->
            <a href="#home">
                <div class="navBtn">
                    <img src="../asset/home.png" alt="home-icon">
             
                    <p>Home</p>
                </div>
            </a>
            <!--ServiceBtn-->
            <a href="#services">
                <div class="navBtn">
                    <img src="../asset/Service.png" alt="services-icon">
                    <p>Services</p>
                </div>
            </a>
            <!--AboutBtn-->
            <a href="#about">
                <div class="navBtn">
                    <img src="../asset/about 1.png" alt="about-icon">
             
                    <p>About</p>
                </div>
            </a>
            <!--DoctorBtn-->
            <a href="#doctor">
                <div class="navBtn">
                    <img src="../asset/DocImg.png" alt="doctors-icon">
                    <p>Doctors</p>
                </div>
            </a>
            <!--FaqBtn-->
            <a href="#faq">
                <div class="navBtn">
                    <img src="../asset/faqImg.png" alt="faq-icon">
                    <p>FAQ</p>
                </div>
            </a>
            <!--ContactUsBtn-->
            <a href="#">
                <div class="navBtn">
                    <img src="../asset/contactUs.png" alt="contact-us">
                    <p>Contact us</p>
                </div>
            </a> 
        </div>

        <!--myProfileBtn-->
        
        <div class="myProfile">
            <a href="#">
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
                <img src="../asset/Consultation.png" alt="consultations"  draggable="false" >
            </div>
        </a>
            <a href="">

            <div class="card">
                <img src="../asset/Symptom.png" alt="Symptom">
            </div>
        </a>
            <a href="">
                <div class="card">
                <img src="../asset/Remedies.png" alt="Remedies">
                </div>
        </a>
            <a href="">     
                <div class="card">
                <img src="../asset/Report.png" alt="Report">
            </div>
        </a>
            <a href=""><div class="card">
                <img src="../asset/Delivery.png" alt="Delivery">
            </div>
        </a>
        </div>
    </section>


    <!--Doctor-->
    <section id="doctor">
        <div class="doctor-head"><h1>Popular Doctors</h1></div>
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
</body>
<script src="../scripts/script.js"></script>
</html>