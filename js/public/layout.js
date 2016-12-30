$(document).ready(function() {
 
    $(document).on('keyup keypress', '.number', function(e) {
        if (e.keyCode == 8 || e.keyCode == 46) {} else {
            var letters = ' 123456789';
            return (letters.indexOf(String.fromCharCode(e.which)) != -1);
        }
    });  
}); 
