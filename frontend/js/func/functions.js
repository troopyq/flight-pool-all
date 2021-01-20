// функция отправки данных на сервер и конвертирование ответа в обьект
export async function sendData(
  url,
  method = 'POST',
  body = null,
  contentType = 'application/json',
) {
  let res = await fetch(url, {
    method: method,
    headers: {
      'Content-Type': contentType,
    },
    body: body,
  });

  // res = await res.json();
  return res;
}

/**
 *
 * @param {string} pageNotAuth Set name page if not auth
 * @param {string} pageAuth Set name page if auth
 */
export function checkUser(pageNotAuth = null, pageAuth = null) {
  if (!sessionStorage.getItem('token')) {
    if (pageNotAuth) {
      location.replace(`/frontend/${pageNotAuth}.html`);
    }
  } else if (pageAuth) {
    location.replace(`/frontend/${pageAuth}.html`);
  }
}

export function getAirports(params) {}

//рендер результатов поиска
export function renderSearch() {
  //если есть в сесии последний поиск, мы его подставляем в страницу
  if (sessionStorage.getItem('dataForm')) {
    let dataForm = JSON.parse(sessionStorage.getItem('dataForm'));

    for (let inp in dataForm) {
      let _input = document.querySelector(`[name=${inp}]`);
      _input.value = dataForm[inp];
    }
  }
  if (sessionStorage.getItem('dataSearch')) {
    let dataSearch = JSON.parse(sessionStorage.getItem('dataSearch'));
    renderItemsSearch(dataSearch);
  }
}

// функция для работы формы поиска
export function useFormSearch(formSelector) {
  let _form = document.querySelector(formSelector);

  _form.addEventListener('submit', submitForm);

  function submitForm(e) {
    e.preventDefault();
    let arrInputs = e.target.querySelectorAll('input');
    let dataForm = {};

    arrInputs.forEach((inp) => {
      if (inp.value.length) dataForm[inp.name] = inp.value;
    });

    sendData(`../../api/flight${dataToGet(dataForm)}`, 'GET')
      .then((res) => res.json())
      .then((res) => {
        sessionStorage.setItem('dataForm', JSON.stringify(dataForm));
        sessionStorage.setItem('dataSearch', JSON.stringify(res.data));

        // если мы на главной странице
        if (!window.location.pathname.includes('result-search')) {
          window.location.replace('/frontend/result-search.html');
        } else {
          //чистим контейнер для новых результатов
          document.querySelector('.search-result').innerHTML = '';
          // начинаем рендерить результаты
          renderSearch();
        }
      }) // обработка ошибки
      .catch((err) => alert(err));
  }

  // локальная функция для перевода обьекта в строку для поиска GET
  function dataToGet(objData) {
    let query = '?';
    for (let key in objData) {
      query += `${key}=${objData[key]}&`;
    }
    return query.slice(0, -1);
  }
}
// рендер результатов поиска
function renderItemsSearch(dataObj) {
  // рендер направлений полета и карточек (внутренняя функцуия)
  const render = (arr, title, _where) => {
    let h1 = document.createElement('h1');
    h1.className = 'search-result__title';
    let tempTitle = `<span id="search-from">${title.from}</span> - <span class="search-to">${title.to}</span>`;
    h1.innerHTML = tempTitle;
    _where.appendChild(h1);

    let dataForm = JSON.parse(sessionStorage.getItem('dataForm')) || 1;

    arr.forEach((item) => {
      let _res = document.createElement('div');
      _res.className = 'search-result__result result';
      let temp = `
      <div class="result__block">
        <ul>
          <li>Номер рейса: <span class="info__id">${item.flight_code}</span></li>
          <li>Воздушное судно: <span class="info__id"> Boing A-1234</span></li>
          <li>Дата вылета: <span class="info__id">${item.from.date}</span></li>
        </ul>
      </div>
      <div class="result__block">
        <ul>
          <li>Время вылета: <span class="info__id">${item.from.time}</span></li>
          <li>Время прилета: <span class="info__id">${item.to.time}</span></li>
          <li>Время в пути: <span class="info__id">${diffTime(
            item.from.date,
            item.from.time,
            item.to.date,
            item.to.time,
          )}</span></li>
        </ul>
      </div>
      <div class="result__block">
        <ul>
          <li>Вероятность вылета: <span class="info__id result-chance"><span class="info__data">${Math.round(
            100 - (item.availability / 56) * 100,
          )}</span> %</span></li>
          <li>Стоимость: <span class="info__id result-cust"><span class="info__data">${
            item.cost * +dataForm.passengers || item.cost
          }</span> руб</span> </li>
          <li><a href=""><button class="btn btn_green">Перейти</button></a></li>
        </ul>
      </div>`;
      _res.innerHTML = temp;
      _where.appendChild(_res);
    });
  };

  let _result = document.querySelector('.search-result');
  let arrItems = [],
    itemsTo = [],
    itemsBack = [],
    titleTo = {},
    titleBack = {};

  for (let objName in dataObj) {
    dataObj[objName].forEach((obj) => arrItems.push(obj));
    if (objName == 'flights_to') {
      dataObj[objName].forEach((obj) => itemsTo.push(obj));
      titleTo.from = dataObj[objName][0].from.city;
      titleTo.to = dataObj[objName][0].to.city;
    } else if (objName == 'flights_back') {
      dataObj[objName].forEach((obj) => itemsBack.push(obj));
      titleBack.from = dataObj[objName][0].from.city;
      titleBack.to = dataObj[objName][0].to.city;
    }
  }

  render(itemsTo, titleTo, _result);
  render(itemsBack, titleBack, _result);
}

function diffTime(date1, time1, date2, time2) {
  let t1 = Date.parse(`${date1}T${time1}`);
  let t2 = Date.parse(`${date2}T${time2}`);

  let diff = t2 - t1;
  let hours = Math.floor((diff / 1000 / 60 / 60) % 24);
  let minutes = Math.floor((diff / 1000 / 60) % 60);

  return `${hours}:${minutes}`;
}

export function profile() {
  let isOk = false;
  const token = sessionStorage.getItem('token') || null;
  let userData = {};
  console.log(token);

  if (!token) location.replace('/frontend/signin.html');

  getUserData('../../api/user', 'GET', 'application/json', token)
    .then((res) => {
      return res.json();
    })
    .then((res) => {
      console.log(res);

      if (!res.error) {
        isOk = true;
        userData = res;
        renderUserData(userData);
      } else {
        alert('Ошибка авторизации');
      }
    })
    .catch((err) => {
      console.log('Произошла ошибка');
      console.log(err);
    });

  if (isOk) {
    return userData;
  } else {
    // alert('Что-то пошло не так');
    return null;
  }

  function renderUserData(userData) {
    let _firstName = document.querySelector('#pass_first_name');
    let _lastName = document.querySelector('#pass_last-name');
    _firstName.textContent = userData['first_name'];
    _lastName.textContent = userData['last_name'];
  }

  async function getUserData(url, method = 'GET', contentType = 'application/json', token) {
    let res = await fetch(url, {
      method: method,
      headers: new Headers({
        'Content-Type': contentType,
        Authorization: 'Bearer ' + token,
      }),
    });

    return res;
  }
}
