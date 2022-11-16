/* Instantiate single textfield component rendered in the document*/
const textFields = document.querySelectorAll(".mdc-text-field");
for (const textField of textFields) {
  mdc.textField.MDCTextField.attachTo(textField);
}

$(document).ready(function () {  
  const closeBtn = document.querySelectorAll(".close-modal");

  function closeModal() {
    const modalContainer = document.getElementById("modal-container");
    modalContainer.classList.remove("show-modal");
  }

  closeBtn.forEach((close) => close.addEventListener("click", closeModal));
});
