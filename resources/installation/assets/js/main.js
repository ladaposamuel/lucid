window.onload = function() {
  // disable default behavior for forms (reload once a buttun is clicked)
  const form = document.querySelector("#installForm");
  // handle form switching
  let steps = document.getElementsByClassName("step-form");
  let stepOneForm = steps[0];
  let stepTwoForm = steps[1];
  let stepOneRequired = [...stepOneForm.getElementsByClassName("required")];
  let stepTwoRequired = [...stepTwoForm.getElementsByClassName("required")];

  function isEmpty(input) {
    return input.value == null || input.value == "";
  }

  document.getElementById("nextButton").addEventListener("click", function() {
    event.preventDefault();
    for (let required of stepOneRequired) {
      if (required.value == null || required.value == "") {
        required.style.backgroundColor = "#ff9389";
      }
    }

    if (stepOneRequired.every(isEmpty)) {
      let errorMessage = document.querySelector("#errorMessage");
      errorMessage.textContent = "Please fill all fileds.";
      errorMessage.style.color = "#ff9389";
    } else {
      stepOneForm.style.display = "none";
      stepTwoForm.style.display = "initial";
      document.querySelector("#errorMessage").textContent = "";
    }
  });
  document
    .getElementById("previousButton")
    .addEventListener("click", function() {
      event.preventDefault();
      stepTwoForm.style.display = "none";
      stepOneForm.style.display = "initial";
    });

  // make sure accept terms and conditions is checked before enabling install button
  let acceptTermsButton = document.querySelector("#acceptTerms");
  let installButton = document.getElementById("installButton");

  acceptTermsButton.addEventListener("change", function() {
    installButton.toggleAttribute("disabled");
  });

  installButton.addEventListener("click", function() {
    event.preventDefault();
    if (!acceptTermsButton.checked && !installButton.hasAttribute("disabled")) {
      document.getElementById("validateTerms").textContent =
        "Kindly accept terms& conditions";
    } else {
      document.getElementById("validateTerms").textContent = "";
    }
    for (let required of stepTwoRequired) {
      if (required.value == null || required.value == "") {
        required.style.backgroundColor = "#ff9389";
      }
    }

    if (stepTwoRequired.every(isEmpty)) {
      document.getElementById("validateTerms").textContent =
        "Please fill all fileds";
    } else {
      form.submit();
    }
  });
};
