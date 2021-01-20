import { sendData } from './func/functions.js';

document.addEventListener('DOMContentLoaded', () => {
  let formIn = document.querySelector('#signin');

  if (sessionStorage.getItem('userName')) {
    formIn.querySelector('[name=phone]').value = sessionStorage.getItem('userName');
  }
  formIn.addEventListener('submit', signIn);

  function signIn(e) {
    console.log('Auth...');
    e.preventDefault();

    let formData = {};

    formIn.querySelectorAll('input').forEach((input) => {
      formData[input.getAttribute('name')] = input.value;
    });

    sessionStorage.setItem('userName', formData.phone);

    sendData('../../api/login', 'POST', JSON.stringify(formData))
      .catch((err) => console.log(err))
      .then((res) => {
        console.log('THEN 1 - ');
        console.log(res);
        return res.json();
      })
      .then((res) => {
        console.log('THEN 2 - ');
        console.log(res);

        if (!res.error) {
          if (res.data.message == 'success') {
            alert('Успешно!');
            sessionStorage.setItem('token', res.data.token);
            // document.cookie = `token=${res.data.token}`;
            // location.href= '/frontend/profile.html';
            location.replace('/frontend/profile.html');
          }
        } else {
          throw new Error(res.error.message);
        }
      })
      .catch((err) => {
        alert(err.message);
        console.log('Error catch - ');
        console.dir(err.message);
      })
      .finally((e) => {
        console.log('finally');
      });
  }

  // async function postData(url, body, contentType = 'application/json') {
  //   let res = await fetch(url, {
  //     method: 'POST',
  //     headers: {
  //       'Content-Type': contentType,
  //     },
  //     body: body,
  //   });

  //   res = await res.json();
  //   return res;
  // }
});
