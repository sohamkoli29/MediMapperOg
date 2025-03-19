
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

// Array of common diseases


// DOM Elements
const input = document.getElementById("DiseaseInput");
const suggestionBox = document.getElementById("suggestions");
const predictButton = document.getElementById("predictButton");
const resetButton = document.getElementById("resetButton");
const resultsDiv = document.getElementById("results");

// Store the current disease (allowing custom inputs)
let selectedDisease = "";

// Function to show disease suggestions
function showSuggestions(query) {
    suggestionBox.innerHTML = "";
    suggestionBox.style.display='block';
    if (!query) return;

    // Filter diseases that match the query (case-insensitive)
    const filteredDiseases = diseases.filter(disease =>
        disease.toLowerCase().includes(query.toLowerCase())
    );

    // Populate suggestion list
    filteredDiseases.forEach(disease => {
        const suggestionItem = document.createElement("li");
        suggestionItem.className = "suggestion-item";
        suggestionItem.textContent = disease;

        // On click, select the disease and clear suggestions
        suggestionItem.addEventListener("click", () => {
            selectedDisease = disease;
            input.value = disease;
            updateResults();
            suggestionBox.innerHTML = "";
            
        });

        suggestionBox.appendChild(suggestionItem);
    });

    if (filteredDiseases.length === 0) {
        const noMatch = document.createElement("li");
        noMatch.className = "suggestion-item";
        noMatch.textContent = "No matches found (Press Enter to use your input)";
        suggestionBox.appendChild(noMatch);
    }
}

// Function to update the results display
function updateResults() {
    resultsDiv.innerHTML = selectedDisease
        ? `Selected Disease: ${selectedDisease}`
        : "Selected Disease: None";
}

// Function to reset input and results
function resetAll() {
    input.value = "";
    suggestionBox.innerHTML = "";
    selectedDisease = "";
    updateResults();
}

// Fetch home remedies from Gemini API
async function fetchRemedies() {
    // Use the input value if no suggestion is selected
    if (!selectedDisease) {
        selectedDisease = input.value.trim();
    }

    if (!selectedDisease) {
        alert("Please enter a disease.");
        return;
    }

    try {
        const prompt = `
Suppose you are an Ayurvedic expert. Based on the following disease, provide Ayurvedic home remedies along with dietary and lifestyle recommendations in this strict format nothing more included:

Disease: [Disease Name]
Ayurvedic Remedies (Step-by-Step):
1. [Step 1]<br>
2. [Step 2]<br>
.....
Dietary Recommendations:
- [Diet Item 1]<br>
- [Diet Item 2]<br>
....
Lifestyle Advice:
- [Lifestyle Tip 1]<br>
- [Lifestyle Tip 2]<br>
....


Disease: ${selectedDisease}
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
                <strong>Selected Disease:</strong> ${selectedDisease}<br>
                <strong>Home Remedies:</strong> <br>${data.candidates[0].content.parts[0].text.replace(/\n/g, "<br>")}
            `;
        } else {
            resultsDiv.innerHTML = "No remedies found.";
        }
    } catch (error) {
        console.error("Error fetching from Gemini API:", error);
        resultsDiv.innerHTML = "Error fetching remedies. Try again later.";
    }
}

// Event Listeners
input.addEventListener("input", () => showSuggestions(input.value));

// Allow custom input when Enter is pressed
input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        selectedDisease = input.value.trim();
        updateResults();
        suggestionBox.innerHTML = "";
    }
});

predictButton.addEventListener("click", fetchRemedies);
resetButton.addEventListener("click", resetAll);

// Hide suggestions when clicking outside
document.addEventListener("click", (e) => {
    if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
        suggestionBox.innerHTML = "";
    }
});

const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});