//JS file for client side validation for form
document.getElementById('submit-form').addEventListener('submit', function(event) {
	var betInput = document.getElementById('bet');
	var betValue = parseFloat(betInput.value);

	if(isNaN(betValue) || betValue <=0 || betValue > 1000.01) {
		alert('Error: Please input a valid decimal value between 0 and 1000.01.');
		event.preventDefault();
	}
});
