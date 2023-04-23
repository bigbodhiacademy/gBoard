document.addEventListener('DOMContentLoaded', function () {
    const starInputs = document.querySelectorAll('.star-rating input[type="radio"]');
  
    starInputs.forEach((input) => {
      input.addEventListener('change', function () {
        this.checked = true;
        this.setAttribute('checked', 'checked');
      });
    });
  });
  