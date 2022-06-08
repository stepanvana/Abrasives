var btnTop = $('#buttonTop');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btnTop.addClass('show');
  } else {
    btnTop.removeClass('show');
  }
});

btnTop.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});

function checkValid(){
var input = document.getElementById("filterField1").value;

    if (input.trim() == '') {
      document.getElementById("filterField1").className = "input-group-input";
      document.getElementById("filterLabel1").className = "input-group-label";
    } else {
      document.getElementById("filterField1").className = "input-group-input input-group-input-valid";
      document.getElementById("filterLabel1").className = "input-group-label input-group-label-valid";
    }

var input = document.getElementById("filterField2").value;

    if (input.trim() == '') {
      document.getElementById("filterField2").className = "input-group-input";
      document.getElementById("filterLabel2").className = "input-group-label";
    } else {
      document.getElementById("filterField2").className = "input-group-input input-group-input-valid";
      document.getElementById("filterLabel2").className = "input-group-label input-group-label-valid";
    }

var input = document.getElementById("filterField3").value;

    if (input.trim() == '') {
      document.getElementById("filterField3").className = "input-group-input";
      document.getElementById("filterLabel3").className = "input-group-label";
    } else {
      document.getElementById("filterField3").className = "input-group-input input-group-input-valid";
      document.getElementById("filterLabel3").className = "input-group-label input-group-label-valid";
    }
}