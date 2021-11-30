const wrapper = document.querySelector(".img-wrapper")
const wrapperPics = document.querySelector(".img-wrapper-pics")
const fileName = document.querySelector(".file-name")
const fileNamePics = document.querySelector(".file-name-pics")
const cancelBtn = document.querySelector("#cancel-btn")
const cancelBtnPics = document.querySelector("#cancel-btn-pics")
const defaultBtn = document.querySelector("#receiptFile")
const pictureBtn = document.querySelector("#picture-btn")
const gambar = document.querySelector("#gambar")
const gambarPics = document.querySelector("#gambar-picture")
let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\.\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

function preview(){
  const file = defaultBtn.files[0]
  const reader = new FileReader()
  reader.onload = function() {
    gambar.src = reader.result
    wrapper.classList.add('active')
  }
  cancelBtn.onclick = function(){
    gambar.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
    wrapper.classList.remove('active')
  }
  if (file) reader.readAsDataURL(file)
  if (defaultBtn.value) fileName.textContent = defaultBtn.value.match(regExp)
}

function previewPics(){
  const file = pictureBtn.files[0]
  const reader = new FileReader()
  reader.onload = function() {
    gambarPics.src = reader.result
    wrapperPics.classList.add('active')
  }
  cancelBtn.onclick = function(){
    gambarPics.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
    wrapperPics.classList.remove('active')
  }
  if (file) reader.readAsDataURL(file)
  if (pictureBtn.value) fileNamePics.textContent = pictureBtn.value.match(regExp)
}