window.onload = function () {

  let selKindPrice = document.querySelector('select[name=selectKindPrice]');
  let priceRange1 = document.querySelector('input[name=priceRange1]');
  let priceRange2 = document.querySelector('input[name=priceRange2]');
  let selMoreLess = document.querySelector('select[name=selectMoreLess]');
  let countItems = document.querySelector('input[name=countItems]');

  document.querySelector('#send').onclick = function () {

    let params = 'selKindPrice=' + selKindPrice.options[selKindPrice.selectedIndex].text + '&' + 'priceRange1=' + priceRange1.value + '&' + 'priceRange2=' + priceRange2.value + '&' + 'selMoreLess=' + selMoreLess.options[selMoreLess.selectedIndex].text + '&' + 'countItems=' + countItems.value;

    ajaxPost("Transfer.php", params, callback = function (data) {

      function getDel() {
        let all = document.querySelectorAll('.del');
        for (let i = 0; i < all.length; i++) {
          all[i].remove();
        }

      }

      function createTable() {
        let table = document.querySelector('.tbl'); // берем таблицу
        let td;
        let lastElem;
        let tr;
        for (let i = 0; i < response.length; i++) {

          
          tr = document.createElement("tr"); // создаем строку

          
          table.appendChild(tr); // добавляем строку в наше дерево 
          table.lastChild.setAttribute("class", "del"); // добавляем этой строке класс del 

          for (let j = 0; j < response.length[[]].length; j++) {
            
            td = document.createElement("td"); // создаем ячейку
            table.lastChild.appendChild(td); // закидываем ее в нашу строку tr
            table.lastChild.children[j].setAttribute("class", "del"); // устанавливаем ячейке атрибут 
            table.lastChild.children[j].innerHTML = response[i][j]; // заноосим данные в ячейку  
            if (j == 0) {
              lastElem.children[j].innerHTML = i + 1; // проверка если это первый элемент строки то устанавливаем новый ID
            } else if (j == 7) { // если последний элемент (ячейка примечание) то удаляем из нее данные.
              lastElem.children[j].innerHTML = " ";
            }


          }


        }
      }

      if (data == 'empty') {
        document.querySelector('#err').innerHTML = 'Заполните все поля';

      } else if (data == 'IsNotNumber') {
        document.querySelector('#err').innerHTML = 'Введите целые числа';
      } else {
        var response = JSON.parse(data);
        getDel();
        createTable(response);
      }
    });
  }
}

function ajaxPost(url, params, callback) {
  let dataBack = callback || function (data) {};

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    request = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    request = new ActiveXObject("Microsoft.XMLHTTP");
  }

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      dataBack(request.responseText);
    }
  };
  request.open('POST', url);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send(params);
}