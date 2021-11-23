const dropArea = document.querySelector(".drag-area"),
      dataArea = document.querySelector(".data-area"),
      previewArea = document.querySelector(".preview-area"),
      response = document.querySelector(".response"),
      dragText = dropArea.querySelector("header"),
      select = dropArea.querySelector("button.select"),
      upload = dataArea.querySelector("button.upload"),
      input = dropArea.querySelector("input");

let images = [];
let xmlHttp = new XMLHttpRequest();
select.onclick = () => {
  input.click();
}
upload.onclick = () => {
  if (images || images.length > 0) {
    // https://uploadcare.com/blog/file-upload-ajax/
    let formData = new FormData(), result, prev, name;
    for (let key in images) {
      if (images.hasOwnProperty(key)) {
        formData.append("images[" + key + "]", images[key], images[key].name);
      }
    }

    // обработчик для отправки
    xmlHttp.upload.onprogress = function(event) {
      console.log(event.loaded + ' / ' + event.total);
    }

    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        response.innerHTML = xmlHttp.responseText;
        result = JSON.parse(xmlHttp.responseText);
        console.log(result);
        if (result.files && result.files.length > 0) {
          for (let key in result.files) {
            name = result.files[key];
            prev = document.getElementById(name);
            prev.className = 'success';
            delete images[name];
          }
        }
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
      img = document.createElement('img'),
      span_remove = document.createElement('span');

  img.src = image;
  div.id = hs;
  span_remove.innerText = 'Не загружать';
  span_remove.className = 'remove';
  span_remove.onclick= function() {
    document.getElementById(hs).remove();
    delete images[hs];
  }
  div.appendChild(img);
  div.appendChild(span_remove);
  previewArea.appendChild(div);
}

function deleteImage(uuid) {
  console.log(uuid);
}