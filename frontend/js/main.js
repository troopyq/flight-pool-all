document.addEventListener('DOMContentLoaded', () => {
  let formUp = document.querySelector('#signup');

  formUp.addEventListener('submit', signUp);

  let formIn = document.querySelector('#signin');
  formIn.addEventListener('submit', signUp);
  alert(12);

  function signIn(e) {
    console.log('Auth...');
    e.preventDefault();

    let formData = {};

    formIn.querySelectorAll('input').forEach((input) => {
      formData[input.getAttribute('name')] = input.value;
    });

    postData('../../api/signin.php', JSON.stringify(formData))
      .then((res) => {
        console.log('THEN - ');
        console.log(res);

        if (!res.error) {
          alert('Успешно');
          // location.replace('/profile.html');
        }
      })
      .catch((err) => {
        console.log('Error catch - ');
        console.log(err);
      })
      .finally((e) => {
        if (succes) {
          console.log('finally');
        }
      });
  }

  function signUp(e) {
    console.log('Submit_');
    e.preventDefault();

    let formData = {1}

    formUp.querySelectorAll('input').forEach((input) => {
      formData[input.getAttribute('name')] = input.value;
    });

    let succes = false;
    postData('../../api/signup.php', JSON.stringify(formData))
      .then((res) => {
        console.log('THEN - ');
        console.log(res);

        if (!res.error) {
          alert('Успешно зарегестрировались');
          succes = true;
        }
      })
      .catch((err) => {
        console.log('Error catch - ');
        console.log(err);
        alert('Error');
      })
      .finally((e) => {
        if (succes) {
          console.log('finally');

          setTimeout(() => {
            location.replace('/signin.html');
          }, 2500);
        }
      });
  }

  async function postData(url, body, contentType = 'application/json') {
    let res = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': contentType,
      },
      body: body,
    });
    res = await res.json();
    return res;
  }

  function selectSeats(e) {
    let target = e.target;
    seatsSelected = document.querySelectorAll('.aircraft__seat_select');

    seatsSelected.forEach((seat) => {});

    if (seatsSelected.length < 8) {
      target.classList.toggle('aircraft__seat_select');
    } else {
      target.classList.remove('aircraft__seat_select');
    }
  }
});
