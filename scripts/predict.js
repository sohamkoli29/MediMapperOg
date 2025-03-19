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


// Array of common symptoms

// DOM Elements
const input = document.getElementById("symptomInput");
const suggestionBox = document.getElementById("suggestions");
const predictButton = document.getElementById("predictButton");
const resetButton = document.getElementById("resetButton");
const resultsDiv = document.getElementById("results");

// Store selected symptoms (multiple allowed)
let selectedSymptoms = [];

// Function to show symptom suggestions
function showSuggestions(query) {
    suggestionBox.innerHTML = "";
    suggestionBox.style.display='block';
    if (!query) return;

    // Filter symptoms by query (case-insensitive)
    const filteredSymptoms = symptoms.filter(symptom =>
        symptom.toLowerCase().includes(query.toLowerCase())
    );

    // Populate suggestion list
    filteredSymptoms.forEach(symptom => {
        const suggestionItem = document.createElement("li");
        suggestionItem.className = "suggestion-item";
        suggestionItem.textContent = symptom;

        suggestionItem.addEventListener("click", () => {
            addSymptom(symptom);
            input.value = "";
            suggestionBox.innerHTML = "";
        });

        suggestionBox.appendChild(suggestionItem);
    });

    // If no matches, allow custom input
    if (filteredSymptoms.length === 0) {
        const noMatch = document.createElement("li");
        noMatch.className = "suggestion-item";
        noMatch.textContent = " (Press Enter )to add this symptom to selected list of symptoms";
        suggestionBox.appendChild(noMatch);
    }
}

// Function to add symptoms (allowing custom input)
function addSymptom(symptom) {
    if (symptom && !selectedSymptoms.includes(symptom)) {
        selectedSymptoms.push(symptom);
        updateResults();
    }
}

// Function to update the results display
function updateResults() {
    resultsDiv.innerHTML = selectedSymptoms.length
        ? `Selected Symptoms: ${selectedSymptoms.join(", ")}`
        : "Selected Symptoms: None";
}

// Function to reset everything
function resetAll() {
    input.value = "";
    suggestionBox.innerHTML = "";
    selectedSymptoms = [];
    updateResults();
}

// Function to fetch predicted disease from Gemini API
async function fetchDiseasePrediction() {
    if (selectedSymptoms.length === 0) {
        alert("Please enter at least one symptom.");
        return;
    }

    try {
        const prompt = `
Suppose you are an Indian doctor. Based on the following symptoms, strictly reply in this format:

Predicted Disease: [Disease Name]
Medicines Preferred: [List of Medicines]

Symptoms: ${selectedSymptoms.join(", ")}
`;


        const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                contents: [{
                    parts: [{ text: prompt }]
                }]
            })
        });

        const data = await response.json();

        if (data.candidates && data.candidates[0].content.parts[0].text) {
            resultsDiv.innerHTML = `
                <strong>Selected Symptoms:</strong> ${selectedSymptoms.join(", ")}<br>
                <strong>Prediction:</strong><br>${data.candidates[0].content.parts[0].text.replace(/\n/g, "<br>")}
            `;
        } else {
            resultsDiv.innerHTML = "No prediction found.";
        }
    } catch (error) {
        console.error("Error fetching from Gemini API:", error);
        resultsDiv.innerHTML = "Error fetching prediction. Try again later.";
    }
}

// Event listeners
input.addEventListener("input", () => showSuggestions(input.value));

// Allow custom input on Enter
input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        addSymptom(input.value.trim());
        input.value = "";
        suggestionBox.innerHTML = "";
    }
});

predictButton.addEventListener("click", fetchDiseasePrediction);
resetButton.addEventListener("click", resetAll);

// Hide suggestions when clicking outside
document.addEventListener("click", (e) => {
    if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
        suggestionBox.innerHTML = "";
    }
});
// hamburger

const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});
