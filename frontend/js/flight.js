import { useFormSearch, renderSearch } from './func/functions.js';

if (window.location.pathname.includes('result-search')) {
  renderSearch();
}

useFormSearch('#flight');

let inputsSearch = document.querySelector('#flight').querySelectorAll('input[list=list-search]');

let dataList = document.querySelector('#list-search');

inputsSearch.forEach((input) => {
  input.addEventListener('input', (e) => console.log(e.target.value));
});
