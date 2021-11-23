function addItem(type, name, uuid) {
  let item = document.getElementsByName(name)[0],
      item_name = item.value,
      items_list;

  if (item_name && item_name !== 'undefined') {
    let xmlHttp = new XMLHttpRequest(), formData = new FormData(), response;

    formData.append("item_name", item_name);
    formData.append("item_type", type);
    formData.append("parent_uuid", uuid);
    formData.append("action", 'create');
    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        console.log(xmlHttp.responseText);
        response = JSON.parse(xmlHttp.responseText);
        if (response.result && response.item_uuid && response.result == 'success') {
          items_list = document.getElementById(type + '_list');
          if (items_list) {
            let li = document.createElement('li'),
                a = document.createElement('a');
            li.dataset.uuid = response.item_uuid;
            a.href = '/' + type + '.php?u=' + response.item_uuid;
            a.innerHTML = item_name;
            li.appendChild(a);
            items_list.appendChild(li);
          }

          item.value = '';
        }
      }
    }

    xmlHttp.open("post", "item.php");
    xmlHttp.send(formData);
  }
}

function renameItem(type, uuid, name) {

}

function deleteItem(type, uuid) {

}