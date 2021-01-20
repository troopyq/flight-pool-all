document.addEventListener('DOMContentLoaded', () => {
  let seatsSelected;
  let seats = document.querySelectorAll('.aircraft__seat');
  
  seats.forEach((seat) => {
    seat.addEventListener('click', selectSeats);
  });
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
})