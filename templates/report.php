<?php
include('../scripts/config.php');
session_start();

// Ensure the user is logged in as a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Process file upload
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Analysis - HealthPortal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/report.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tesseract.js/4.0.2/tesseract.min.js"></script>

</head>
<body>
<header>
    <div class="container">
        <nav class="navbar">
             <!-- Hamburger Menu Icon -->
             <div class="hamburger" id="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <a href="indexP.php" class="logo">MediMapper</a>
           
            <!-- Navigation Menu -->
            <ul class="nav-menu" id="nav-menu">
                <li class="nav-item"><a href="consultation.php" class="nav-link">Consultation</a></li>
                <li class="nav-item"><a href="predict.php" class="nav-link">Symptom Checker</a></li>
                <li class="nav-item"><a href="report.php" class="nav-link">Report Analysis</a></li>
                <li class="nav-item active"><a href="remedies.php" class="nav-link">Home Remedies</a></li>
                <li class="nav-item "><a href="delivery.php" class="nav-link">Medicine Delivery</a></li>
            </ul>
            <div class="user-actions">
                <a href="profile.php" class="user-icon"><i class="fas fa-user-circle"></i></a>
            </div>
        </nav>
    </div>
</header>

    <!-- Main Content -->
    <main class="container">
        <section class="hero">
            <h1>Comprehensive Report Analysis</h1>
            <input type="file" name="reportFile" class="file-input" id="reportFile" accept=".pdf, image/*" style="display: none;" onchange="handleFileSelect(event)">

            <p>Upload your medical reports for AI-powered analysis, insights, and personalized health recommendations based on your latest test results.</p>
            <button class="cta-button" id="scrollToUpload" onclick="document.getElementById('reportFile').click()">
    <i class="fas fa-upload"></i> Upload Your Reports
</button>
<br><div id="fileNameDisplay01"></div>

<!-- Hidden File Input -->
        </section>

        <section class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3>AI Analysis</h3>
                <p>Our advanced AI analyzes your medical reports to identify abnormalities and potential health concerns.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Trend Tracking</h3>
                <p>Track your health metrics over time to visualize progress and identify patterns.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Action Plan</h3>
                <p>Get personalized recommendations and next steps based on your test results.</p>
            </div>
        </section>

        <section class="upload-section" id="uploadSection">
            <h2>Upload Your Medical Reports</h2>
            <p>Our system supports PDF medical reports including blood tests, urine analysis, imaging reports, and more.</p>
            
           
            
            <form method="POST" enctype="multipart/form-data" id="uploadForm">
            <div class="upload-area" id="dropArea" ondrop="handleDrop(event)" ondragover="handleDragOver(event)">
    <i class="fas fa-cloud-upload-alt"></i>
    <h3>Drag & Drop Your Files Here</h3>
    <p>or click to browse your files</p>
    <input type="file" name="reportFile" class="file-input" id="reportFile" accept=".pdf, image/*" style="display: none;" onchange="handleFileSelect(event)">
    <button type="button" class="cta-button" id="browseButton" onclick="document.getElementById('reportFile').click()">
        <i class="fas fa-upload"></i> Select Files
       
    </button>
    <br><div id="fileNameDisplay02"></div>
    </div>
                
                <div class="file-types">
                    <span class="file-type">PDF</span>
                </div>
                
                <button type="submit" class="submit-button" id="analyzeButton" >
                    <i class="fas fa-brain"></i> Analyze Report
                </button>
            </form>
            
            <div id="uploadStatus" class="upload-status" style="display: none;">
                <div class="loader"></div>
                <p>Processing your report. This may take a moment...</p>
            </div>
        </section>

        <section class="analysis-results" id="analysisResults" style="display:none">
            <div class="results-header">
                <h2>Report Analysis Results</h2>
               
                <div class="download-btns">
                    <button class="download-btn" id="downloadPdfBtn">
                        <i class="fas fa-download"></i> PDF
                    </button>
                    <button class="download-btn" id="shareBtn">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div>
            </div>

            <div class="result"></div>

        
        </section>
    </main>

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
   
    <!-- PDF.js for PDF text extraction -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <!-- Gemini API script -->
     
    <script src="../scripts/report.js"></script>
</body>
</html>