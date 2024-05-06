document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".signup form"),
    continueBtn = form.querySelector(".button input"),
    errorText = form.querySelector(".error-text");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
  });

  // Attach an onclick event handler to the continueBtn element
  continueBtn.onclick = () => {
    // Create a new XMLHttpRequest object
    let xhr = new XMLHttpRequest();
    // Configure the request: method, URL, and asynchronous flag
    // Asynchronous request means the script will continue to execute while the request is being processed
    xhr.open("POST", "php/signup.php", true);
    // Define a callback function to handle the response
    xhr.onload = () => {
      // Check if the request is completed
      if (xhr.readyState === XMLHttpRequest.DONE) {
        // Check if the response status is OK (200)
        if (xhr.status === 200) {
          // Get the response data
          let data = xhr.response;
          // If the response is "success", redirect to users.php
          if (data === "success") {
            location.href = "users.php";
          } else {
            // Otherwise, display the error message
            errorText.style.display = "block";
            errorText.textContent = data;
          }
        }
      }
    };
    // Create a new FormData object and populate it with the form data
    let formData = new FormData(form);
    // Send the form data to the server using the POST method
    xhr.send(formData);
  };
});


// The request will be sent to the server in the background, and the JavaScript code will continue executing without waiting for the response. Once the response is received, the onload event handler will be triggered to handle the response. If the response is successful, the user will be redirected to the users.php page. Otherwise, an error message will be displayed on the form.