<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Firebase Google Login</title>
    <script type="module">
      import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
      import {
        getAuth,
        signInWithPopup,
        GoogleAuthProvider,
      } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-auth.js";

      // Firebase configuration
      const firebaseConfig = {
        apiKey: "AIzaSyDYuir7ZhbaUg4mXmilSA2nCBtMIveNBl4",
        authDomain: "gasgawe-d0685.firebaseapp.com",
        projectId: "gasgawe-d0685",
      };

      // Initialize Firebase
      const app = initializeApp(firebaseConfig);
      const auth = getAuth(app);
      const provider = new GoogleAuthProvider();

      // Make the login function globally accessible
      window.loginWithGoogle = async function () {
        try {
          const result = await signInWithPopup(auth, provider);
          console.log(result);
          const idToken = await result.user.getIdToken();

          // Display the Firebase token
          document.getElementById("tokenDisplay").textContent = idToken;
          document.getElementById("tokenContainer").style.display = "block";
        } catch (error) {
          console.error("Login error:", error);
          alert("Failed to login. Please try again.");
        }
      };
    </script>
  </head>
  <body>
    <div class="login-container">
      <h1>Login with Google</h1>
      <button onclick="loginWithGoogle()" class="google-btn">
        <img
          src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
          alt="Google Logo"
        />
        Sign in with Google
      </button>
      <div id="tokenContainer" style="display: none; margin-top: 20px">
        <h3>Your Firebase Token:</h3>
        <textarea
          id="tokenDisplay"
          readonly
          style="width: 100%; height: 100px; margin-top: 10px"
        ></textarea>
      </div>
    </div>

    <style>
      .login-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        padding: 20px;
        box-sizing: border-box;
      }

      .google-btn {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
      }

      .google-btn:hover {
        background-color: #f1f1f1;
      }

      .google-btn img {
        width: 20px;
        margin-right: 10px;
      }

      #tokenContainer {
        width: 80%;
        max-width: 600px;
        text-align: center;
      }

      #tokenDisplay {
        word-break: break-all;
        font-family: monospace;
        padding: 10px;
      }
    </style>
  </body>
</html>
