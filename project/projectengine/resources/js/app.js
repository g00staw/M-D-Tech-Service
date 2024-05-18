import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.getElementById('deviceForm').addEventListener('submit', function(event) {
  var serialNumber = document.getElementById('serialnumber').value;
  
  // Sprawdź, czy numer seryjny jest liczbą
  if (isNaN(serialNumber)) {
    alert('Numer seryjny musi być liczbą.');
    event.preventDefault(); // Zapobiegaj wysłaniu formularza
  }
});