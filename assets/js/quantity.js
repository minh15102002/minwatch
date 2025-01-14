document.addEventListener('DOMContentLoaded', function() {
    var plusButtons = document.querySelectorAll('.plus');
    var minusButtons = document.querySelectorAll('.minus');

    plusButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var input = button.parentNode.querySelector('input[type="number"]');
            var currentValue = parseInt(input.value);
            var maxValue = parseInt(input.max);

            if (isNaN(currentValue)) currentValue = 0;
            if (isNaN(maxValue)) maxValue = Infinity;

            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        });
    });

    minusButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var input = button.parentNode.querySelector('input[type="number"]');
            var currentValue = parseInt(input.value);
            var minValue = parseInt(input.min);

            if (isNaN(currentValue)) currentValue = 0;
            if (isNaN(minValue)) minValue = 0;

            if (currentValue > minValue) {
                input.value = currentValue - 1;
            }
        });
    });
});