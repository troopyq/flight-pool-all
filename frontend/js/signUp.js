import { sendData } from './func/functions.js';

document.addEventListener('DOMContentLoaded', () => {
  let formUp = document.querySelector('#signup');

  //если есть сохранение, востанавливаем ведденные данные
  if (sessionStorage.getItem('dataSignUp')) {
    let dataForm = JSON.parse(sessionStorage.getItem('dataSignUp'));
    for (let name in dataForm) {
      formUp.querySelector(`[name=${name}]`).value = dataForm[name];
    }
  }

  formUp.addEventListener('submit', signUp);
  function signUp(e) {
    console.log('Submit_');
    e.preventDefault();

    let formData = {};

    formUp.querySelectorAll('input').forEach((input) => {
      formData[input.getAttribute('name')] = input.value;
    });
    //сохраняем значения в форме
    sessionStorage.setItem('dataSignUp', JSON.stringify(formData));
    sessionStorage.setItem('userName', formData.phone);

    let succes = false;

    sendData('../../api/register', 'POST', JSON.stringify(formData))
      .then((res) => {
        console.log('1 зен');

        if (res.status !== 204) {
          console.log('в 1 зен не 204 код');
          return res.json();
          // throw new Error(JSON.stringify(res.json()));
        } else {
          return res;
        }
      })
      .then((res) => {
        console.log('2 зен');
        if (res.hasOwnProperty('error')) {
          console.log(res);
          for (let err in res.error.errors) {
            alert(res.error.errors[err]);
          }
        } else {
          // удаляем сохранение формы
          sessionStorage.removeItem('dataSignUp');
          alert('Успешно зарегестрировались');
          //переходим в авторизацию
          location.replace('/frontend/signin.html');
        }
        // for (let err in res.error.errors) {
        //   alert(res.error.errors[err]);
        // }
      })
      .catch((err) => {
        console.log('произошла ошибка');
        // console.log(JSON.parse(err));
      });

    // sendData('../../api/register', 'POST', JSON.stringify(formData))
    //   .then((res) => {
    //     if (res.status !== 204) {
    //       res = res.json();
    //     } else {
    //       return res;
    //     }
    //   })
    //   .catch((err) => console.log('Нет ответа json', err))
    //   .then((res) => {
    //     console.log('THEN - ');
    //     console.log(res);

    //     if (!res.error && res.status === 204) {
    //       alert('Успешно зарегестрировались');
    //       succes = true;
    //       // удаляем сохранение формы
    //       sessionStorage.removeItem('dataSignUp');
    //       //переходим в авторизацию
    //       location.replace('/frontend/signin.html');
    //     } else {
    //       console.log('Вызов ошибки');
    //       throw new Error(res);
    //     }
    //   })
    //   .catch((err) => {
    //     console.log('Error catch - ');
    //     console.log(err);
    //     alert('Error');
    //   })
    //   .finally((e) => {});
  }

  // async function postData(url, body, contentType = 'application/json') {
  //   let res = await fetch(url, {
  //     method: 'POST',
  //     headers: {
  //       'Content-Type': contentType,
  //     },
  //     body: body,
  //   });

  //   return res;
  // }
});
