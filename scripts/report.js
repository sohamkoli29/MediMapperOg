const dropArea = document.getElementById('dropArea');
const fileNameDisplay01 = document.getElementById('fileNameDisplay01');
const fileNameDisplay02 = document.getElementById('fileNameDisplay02');
const analysisResults = document.getElementById('analysisResults');
const result = document.querySelector('.result');

let extractedText = ""; // Variable to store extracted text


pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';


function handleDragOver(event) {
    event.preventDefault();
    dropArea.classList.add('drag-over');
}

function handleDrop(event) {
    event.preventDefault();
    dropArea.classList.remove('drag-over');
    const files = event.dataTransfer.files;
    handleFiles(files);
}

function handleFileSelect(event) {
    const files = event.target.files;
    handleFiles(files);
}

function handleFiles(files) {
    fileNameDisplay01.innerHTML = '';
    fileNameDisplay02.innerHTML = '';
    for (const file of files) {
        if (file.type === 'application/pdf' || file.type.startsWith('image/')) {
            const fileItem = document.createElement('p');
            fileItem.textContent = `Uploaded: ${file.name}`;
            fileNameDisplay01.appendChild(fileItem);
            fileNameDisplay02.appendChild(fileItem.cloneNode(true));
        } else {
            alert('Only PDF and image files are allowed.');
        }
    }
}

// Wait for DOM to load
document.addEventListener("DOMContentLoaded", function () {
    const analyzeButton = document.getElementById("analyzeButton");
    const reportFile = document.getElementById("reportFile");

    analyzeButton.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent form submission
        if (reportFile.files.length === 0) {
            alert("Please upload a PDF or image.");
            return;
        }
        const file = reportFile.files[0];
        if (file.type === "application/pdf") {
            extractTextFromPDF(file);
        } else if (file.type.startsWith("image/")) {
            extractTextFromImage(file);
        } else {
            alert("Unsupported file type. Upload PDF or image.");
        }
    });
});

// Extract text from PDF (including image-based PDFs)
function extractTextFromPDF(file) {
    const fileReader = new FileReader();
    fileReader.onload = function () {
        const typedArray = new Uint8Array(this.result);
        pdfjsLib.getDocument(typedArray).promise.then(function (pdf) {
            let textContent = "";
            let pagePromises = [];

            for (let i = 1; i <= pdf.numPages; i++) {
                pagePromises.push(pdf.getPage(i).then(function (page) {
                    return page.getTextContent();
                }));
            }
                
            Promise.all(pagePromises).then(function (pages) {
                pages.forEach(function (pageItems) {
                    pageItems.items.forEach(function (item) {
                        textContent += item.str + " ";
                    });
                });

                extractedText = formatText(textContent); // Store in variable
                console.log("PDF Text Extracted:", extractedText);
                handleExtractedText(textContent);


                // Check for image-based PDFs using Tesseract
                if (textContent.trim().length === 0) {
                    extractTextFromImage(file); // Fallback to OCR
                }
            });
        });
    };
    fileReader.readAsArrayBuffer(file);
}

// Extract text from images (JPG, PNG, etc.)
function extractTextFromImage(file) {
    Tesseract.recognize(file, 'eng', {
        logger: m => console.log(m) // Logs Tesseract progress
    }).then(({ data: { text } }) => {
        extractedText = formatText(text); // Store in variable

        console.log("Image Text Extracted:", extractedText);
        handleExtractedText(text);
    }).catch(err => {
        console.error("Error extracting image text:", err);
    });
}

// Format extracted text: separate table records by commas
function formatText(text) {
    return text.replace(/\s+/g, " ").replace(/(\d+)\s+(\d+)/g, "$1,$2");
}
  


//api
let apiKey = "";

async function fetchApiKey() {
  try {
    const response = await fetch('../scripts/api.php'); // Path to your PHP file
    const data = await response.json();
    apiKey = data.apiKey; // Store the API key
    console.log("API Key Loaded");
  } catch (error) {
    console.error("Error fetching API key:", error);
  }
}
fetchApiKey();
async function sendToAPI(text) {
    
    try {
        const prompt=`You are a medical expert. Based on the provided test report, give me a solution strictly using this format: 
              <strong>- Diet you should follow:</strong><br> 
              <strong>- Medicine:</strong><br> 
              <strong>- Exercise:</strong><br> 

                Here is the test report: ${text}`;
        const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
          body: JSON.stringify({
            contents: [{
                role: "user",
                parts: [{ text: prompt }]
        }]
    })
        });

        if (!response.ok) {
            throw new Error("Failed to fetch analysis.");
        }

        const data = await response.json();
       
        const analysis = data.candidates[0].content.parts[0].text;

        console.log("Gemini Response:", analysis);
        
        const formattedText = analysis
    .replace(/\n/g, '<br>')              // Convert new lines to <br>
    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        result.innerHTML = formattedText;
        analysisResults.style.display = 'block';
    } catch (error) {
        console.error("Error sending data to API:", error);
        result.textContent = "Error fetching analysis. Please try again.";
        analysisResults.style.display = 'block';
    }
}

// Call sendToAPI after extracting text
function handleExtractedText(text) {
    extractedText = formatText(text);
    console.log("Extracted Text:", extractedText);
    sendToAPI(extractedText);
}

// Hamburger


const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});