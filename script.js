const dropArea = document.querySelector(".drag-area"),
      previewArea = document.querySelector(".preview-area"),
      response = document.querySelector(".response"),
      dragText = dropArea.querySelector("header"),
      select = dropArea.querySelector("button.select"),
      upload = dropArea.querySelector("button.upload"),
      input = dropArea.querySelector("input");

let images = [];

select.onclick = () => {
  input.click();
}
upload.onclick = () => {
  if (images || images.length > 0) {
    // https://uploadcare.com/blog/file-upload-ajax/
    let formData = new FormData();
    for (let key in images) {
      if (images.hasOwnProperty(key)) {
        formData.append("images[" + key + "]", images[key], images[key].name);
      }
    }

    let xmlHttp = new XMLHttpRequest();

    // обработчик для отправки
    xmlHttp.upload.onprogress = function(event) {
      console.log(event.loaded + ' / ' + event.total);
    }

    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        response.innerHTML = xmlHttp.responseText;
      } else {
        response.innerHTML = 'Upload error. Try again.';
      }
    }
    xmlHttp.open("post", "upload.php");
    xmlHttp.send(formData);
  }
}

input.addEventListener("change", function () {
  dropArea.classList.add("active");
  showFile(this.files);
});

// Если пользователь наводит курсор на DropArea
dropArea.addEventListener("dragover", (event) => {
  event.preventDefault(); // предотвращение поведения по умолчанию
  dropArea.classList.add("active");
  dragText.textContent = "Отпустите, чтобы загрузить файл";
});
// Если пользователь отводит курсор на DropArea
dropArea.addEventListener("dragleave", () => {
  dropArea.classList.remove("active");
  dragText.textContent = "Перетащите и отпустите, чтобы загрузить файл";
});
// Если пользователь перетащит файл в DropArea
dropArea.addEventListener("drop", (event) => {
  event.preventDefault(); // предотвращение поведения по умолчанию
  showFile(event.dataTransfer.files);
});

function showFile(files) {
  if (files || files.length > 0) {
    for (let i = 0; i < files.length; i++) {
      let hs,
          fileURL,
          fileReader,
          file = files[i],
          fileType = file.type,
          validExtensions = ["image/jpeg", "image/jpg", "image/png"];
      if (validExtensions.includes(fileType)) {
        // Составление идентификатора изображения
        hs = file.lastModified + '_' + file.size;
        if (!images[hs]) {
          fileReader = new FileReader();
          fileReader.onload = () => {
            fileURL = fileReader.result;
            /*let imgTag = `<img src="${fileURL}" alt="image">`; dropArea.innerHTML = imgTag;*/
            createPreviewObject(fileURL, hs);
            images[hs] = file;
          }
          fileReader.readAsDataURL(file);
        } else {
          console.warn("Image <" + file.name + "> has already been added!");
        }
      } else {
        console.warn("File <" + file.name + "> is not an Image File!");
      }
    }
  }

  dropArea.classList.remove("active");
  dragText.textContent = "Перетащите и отпустите, чтобы загрузить файл";
}

function createPreviewObject(image, hs) {
  let div = document.createElement('div'),
      img = document.createElement('img');

  img.src = image;
  div.className = 'image';
  div.id = hs;
  div.appendChild(img);
  previewArea.appendChild(div);
}