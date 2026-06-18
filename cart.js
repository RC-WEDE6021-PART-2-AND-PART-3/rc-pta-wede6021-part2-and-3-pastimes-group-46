function updateQuantity(element, increment) {
    var inputBox = element.parentElement.querySelector('.input-box');
    var currentValue = parseInt(inputBox.value);
    if (increment > 0) {
        inputBox.value = currentValue + 1;
    } else if (increment < 0 && currentValue > 1) {
        inputBox.value = currentValue - 1;
    }
}