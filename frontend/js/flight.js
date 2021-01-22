import { useFormSearch, renderSearch, sendData } from './func/functions.js';

if (window.location.pathname.includes('result-search')) {
  renderSearch();
}

useFormSearch('#flight');

let inputsSearch = document.querySelector('#flight').querySelectorAll('input[list=list-search]');

let dataList = document.querySelector('#list-search');

inputsSearch.forEach((input) => {
  input.addEventListener('input', (e) => {
    if (e.target.value.length) {
      sendData(`../../api/airport?query=${e.target.value}`, 'GET')
        .then((res) => res.json())
        .then((res) => {
          dataList.innerHTML = '';
          res.data.items.forEach((item) => {
            let opt = document.createElement('option');
            opt.value = item.iata;
            opt.textContent = `${item.city} ${item.name}`;
            dataList.appendChild(opt);
          });
        });
    }
  });
});
