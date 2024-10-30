const wrapper = document.querySelector(".img-wrapper");
const fileName = document.querySelector(".file-name");
const cancelBtn = document.querySelector("#cancel-btn");
const mainImage = document.querySelector("#main-image");
const gambar = document.querySelector("#gambar");
let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\.\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

function preview() {
  const file = mainImage.files[0]
  const reader = new FileReader()

  reader.onload = function () {
    gambar.src = reader.result;
    wrapper.classList.add("active");
  };

  cancelBtn.onclick = function () {
    gambar.src =
      "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
    wrapper.classList.remove("active");
  };

  if (file) {
    reader.readAsDataURL(file);
  }
  if (mainImage.value) {
    fileName.textContent = mainImage.value.match(regExp)
  } 
}

function uploadImage(idRegistrasi) {
  const request = new XMLHttpRequest()
  const accessToken = localStorage.getItem('accessToken')
  const file = mainImage.files[0];
  const query = `?id=${idRegistrasi}`

  compressImage(file, 0.7, 800, (compressedFile) => {
    var formData = new FormData()
    formData.append("receipt", compressedFile)

    request.open('POST', `${mainURL}registrasi/receipt${query}`)
    request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
    request.send(formData);
  });

  request.onload = function() {
    const response = JSON.parse(request.responseText)
    const statusCode = response.statusCode
    
    if (statusCode == 401) {
      signOut()
    } else if (statusCode != 200) {
      const title = response.error
      const messages = response.message
      console.log(response)

      attachToView('titleDialog', title)
      attachToView('descriptionDialog', messages)
      openDialog()
    } else {
      changeStatus('Menunggu Konfirmasi', idRegistrasi)
    }
  }
}

function cancelUpload(idRegistrasi) {
  const request = new XMLHttpRequest()
  const accessToken = localStorage.getItem('accessToken')
  const query = `?id=${idRegistrasi}`

  request.onload = function() {
    const response = JSON.parse(request.responseText)
  }

  request.open('DELETE', `${mainURL}registrasi/receipt${query}`)
  request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
  request.send();
}

function getUploadedImage(idRegistrasi) {
  const request = new XMLHttpRequest()
  const accessToken = localStorage.getItem('accessToken')
  const query = `?id=${idRegistrasi}`

  request.onload = function() {
    try {
      const response = JSON.parse(request.responseText)
      const statusCode = response.statusCode
      console.log(response)

      if (statusCode == 401) {
        signOut()
      } else {
        const title = response.error
        const messages = response.message

        attachToView('titleDialog', title)
        attachToView('descriptionDialog', messages)
        openDialog()
      }
    } catch (error) {
      var urlCreator = window.URL || window.webkitURL
      var imageUrl = urlCreator.createObjectURL(this.response)
      gambar.src = imageUrl

      mainImage.disabled = true
      if (typeof(unggahReceipt) != "undefined") {
        unggahReceipt.style.display = 'none'
        // unggahReceipt.innerHTML = "Batal Unggah"
        // unggahReceipt.style.backgroundColor = "#D5001A"
        // unggahReceipt.addEventListener('click', () => cancelUpload(idRegistrasi))
      }
    }
  }

  request.open('GET', `${mainURL}registrasi/receipt${query}`)
  request.responseType = "blob"
  request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
  request.send();
}

function compressImage(file, quality, maxWidth, callback) {
  const reader = new FileReader();
  reader.readAsDataURL(file);

  reader.onload = function(event) {
      const img = new Image();
      img.src = event.target.result;

      img.onload = function() {
          // Set the canvas dimensions
          const canvas = document.createElement('canvas');
          const ctx = canvas.getContext('2d');

          // Set the new width and height
          const scale = maxWidth / img.width;
          canvas.width = maxWidth;
          canvas.height = img.height * scale;

          // Draw the image onto the canvas
          ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

          // Compress the image
          canvas.toBlob(
              (blob) => {
                  const compressedFile = new File(
                    [blob],
                    `compressed_${file.name}`,
                    { type: 'image/jpeg', lastModified: Date.now() }
                  );
                  callback(compressedFile);
              },
              'image/jpeg',  // output format
              quality         // compression quality
          );
      };
  };
}
