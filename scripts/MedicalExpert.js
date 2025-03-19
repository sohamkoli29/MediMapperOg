let apiKey = ""; // Variable to store the API key

// Function to fetch the API key from the backend
async function fetchApiKey() {
  try {
    const response = await fetch("../scripts/api.php"); // Path to your PHP file
    const data = await response.json();
    apiKey = data.apiKey; // Store the API key
    console.log("API Key Loaded");
  } catch (error) {
    console.error("Error fetching API key:", error);
    alert("Failed to load API key. Please try again later.");
  }
}

// Fetch the API key when the page loads
fetchApiKey();

// Chat history stored in memory (simulates bot memory)
let chatHistory = [];

// Function to send a message to the Gemini API
async function sendMessage() {
  // Check if the API key is loaded
  if (!apiKey) {
    alert("API key is not loaded yet. Please wait...");
    return;
  }

  const messageInput = document.getElementById("messageInput");
  const userMessage = messageInput.value.trim();

  if (!userMessage) return; // Do nothing if the input is empty

  // Add user message to chat history
  chatHistory.push({ role: "user", content: userMessage });

  // Display user message in the chat container
  displayMessage(userMessage, "user");

  // Clear the input field
  messageInput.value = "";

  // Show typing indicator
  showTypingIndicator();

  try {
    // Construct the prompt for the Gemini API
    const prompt = `Suppose you are a medical expert and chatting with me as I'm your patient. Keep this in your chat history memory: ${JSON.stringify(
      chatHistory
    )}. Now, respond to this recent message: ${userMessage}.`;

    // Send the message to the Gemini API
    const response = await fetch(
      `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          contents: [
            {
              parts: [
                {
                  text: prompt,
                },
              ],
            },
          ],
        }),
      }
    );

    if (!response.ok) {
      throw new Error("Failed to fetch response from Gemini API");
    }

    const data = await response.json();

    // Extract the AI's response
    const aiMessage = data.candidates[0].content.parts[0].text;

    // Add AI response to chat history
    chatHistory.push({ role: "assistant", content: aiMessage });

    // Display AI message in the chat container
    displayMessage(aiMessage, "bot");

    // Scroll to the bottom of the chat container
    scrollToBottom();
  } catch (error) {
    console.error("Error:", error);
    displayMessage("Sorry, something went wrong. Please try again.", "bot");
  } finally {
    // Hide typing indicator
    hideTypingIndicator();
  }
}

// Function to display a message in the chat container
function displayMessage(message, sender) {
  const chatContainer = document.getElementById("chatContainer");

  // Create a new message element
  const messageElement = document.createElement("div");
  messageElement.classList.add("message", `${sender}-message`);

  // Add message content
  const messageContent = document.createElement("div");
  messageContent.textContent = message;
  messageElement.appendChild(messageContent);

  // Add timestamp
  const timestamp = document.createElement("div");
  timestamp.classList.add("message-time");
  timestamp.textContent = new Date().toLocaleTimeString();
  messageElement.appendChild(timestamp);

  // Append the message to the chat container
  chatContainer.appendChild(messageElement);
}

// Function to show typing indicator
function showTypingIndicator() {
  const chatContainer = document.getElementById("chatContainer");

  // Create typing indicator element
  const typingIndicator = document.createElement("div");
  typingIndicator.classList.add("typing-indicator");

  // Add typing bubbles
  for (let i = 0; i < 3; i++) {
    const bubble = document.createElement("div");
    bubble.classList.add("typing-bubble");
    typingIndicator.appendChild(bubble);
  }

  // Append typing indicator to the chat container
  chatContainer.appendChild(typingIndicator);

  // Scroll to the bottom of the chat container
  scrollToBottom();
}

// Function to hide typing indicator
function hideTypingIndicator() {
  const typingIndicator = document.querySelector(".typing-indicator");
  if (typingIndicator) {
    typingIndicator.remove();
  }
}

// Function to scroll to the bottom of the chat container
function scrollToBottom() {
  const chatContainer = document.getElementById("chatContainer");
  chatContainer.scrollTop = chatContainer.scrollHeight;
}

// Function to clear chat history
function clearChat() {
  chatHistory = []; // Clear chat history
  const chatContainer = document.getElementById("chatContainer");
  chatContainer.innerHTML = `<div class="welcome-message">
    <h3>AI Medical Expert</h3>
    <p>Hello! I'm your AI Medical Expert assistant. How can I help you today?</p>
  </div>`;
}

// Attach event listeners
document.getElementById("messageInput").addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    sendMessage();
  }
});