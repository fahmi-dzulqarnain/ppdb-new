const fileName = document.querySelector(".file-name")
const defaultBtn = document.querySelector("#default-btn")
let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\.\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

function preview(){
  const file = defaultBtn.files[0]
  const reader = new FileReader()
  
  if (file) reader.readAsDataURL(file)
  if (defaultBtn.value) fileName.textContent = defaultBtn.value.match(regExp)
}