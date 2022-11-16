$(document).ready(function () {
  const closeBtn = document.querySelectorAll(".close-modal");

  function closeDialog() {
    const modalContainer = document.getElementById("modal-container");
    modalContainer.classList.remove("show-modal");
  }

  closeBtn.forEach((close) => close.addEventListener("click", closeDialog));
});

function openDialog() {
  const modalContainer = document.getElementById("modal-container");
  modalContainer.classList.add("show-modal");
}
