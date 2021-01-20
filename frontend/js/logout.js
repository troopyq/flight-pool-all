import { sendData } from './func/functions.js';

document.addEventListener('DOMContentLoaded', () => {
  let logout = document.querySelector('#logout');

  logout.addEventListener('click', (e) => {
    e.preventDefault();
    sessionStorage.removeItem('token');
    sendData('../../api/logout', 'GET', null)
      .then((res) => res.json())
      .then((res) => {
        console.log(res.data.message);
        location.replace('/frontend');
      });
  });
});
