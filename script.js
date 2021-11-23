/**
 *
 * @param type
 * @param name
 * @param action - create / rename / delete
 * @param uuid - universally unique identifier item
 * @param parent_uuid - universally unique identifier parent item
 */
function controlItem(type, name, action, uuid, parent_uuid) {
  let items_list,
      xmlHttp = new XMLHttpRequest(),
      formData = new FormData(),
      item,
      response,
      item_name = ''
  ;

  if (action === 'create' || action === 'rename') {
    item = document.getElementsByName(name)[0];
    item_name = item.value;
    formData.append("item_name", item_name);
  }

  formData.append("item_type", type);
  formData.append("action", action);
  formData.append("uuid", uuid);
  formData.append("parent_uuid", parent_uuid);

  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
      console.log(xmlHttp.responseText);
      response = JSON.parse(xmlHttp.responseText);
      if (response.result && response.item_uuid && response.result == 'success') {
        items_list = document.getElementById(type + '_list');
        if (items_list) {
          switch (action) {
            case 'create':
              let li = document.createElement('li'),
                  a = document.createElement('a');
              li.dataset.uuid = response.item_uuid;
              a.href = '/' + type + '.php?u=' + response.item_uuid;
              a.innerHTML = item_name;
              li.appendChild(a);
              items_list.appendChild(li);
              item.value = '';
              break;

            case 'rename':
              document.querySelectorAll("[data-uuid='" + uuid + "'] a")[0].innerHTML = item_name;
              break;

            case 'delete':
              document.querySelectorAll("[data-uuid='" + uuid + "']")[0].remove();
              break;
          }
        }
      }
    }
  }

  xmlHttp.open("post", "item.php");
  xmlHttp.send(formData);
}

function renameItem(type, uuid) {
  let m = document.createElement('div'),
      c = document.createElement('div'),
      i = document.createElement('input'),
      b = document.createElement('button'),
      s = document.createElement('span');

  m.id = 'rename';
  i.type = 'text';
  i.value = document.querySelectorAll("[data-uuid='"+uuid+"'] a")[0].innerHTML;
  i.name = 'new_name';
  b.innerHTML = 'Переименовать';
  b.onclick = function() {
    controlItem(type, 'new_name', 'rename', uuid, 0)
    document.getElementById('rename').remove();
  }
  s.innerHTML = 'Отменить';
  s.className = 'link';
  s.onclick = function() { document.getElementById('rename').remove(); }
  c.appendChild(i);
  c.appendChild(b);
  c.appendChild(s);
  m.appendChild(c);
  document.getElementById('container').appendChild(m);
}