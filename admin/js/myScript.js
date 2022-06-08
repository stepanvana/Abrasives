/*var divsProducts = ["hlavniUdaje", "cenik", "sklad"];
var divsButtonsProducts = ["buttonHlavniUdaje", "buttonCenik", "buttonSklad"];
  var visibleProductDivId = null;
  function divProductVisibility(divId) {
    if(visibleProductDivId === divId) {
      visibleProductDivId = null;
    } else {
      visibleProductDivId = divId;
    }
    hideProductNonVisibleDivs();
  }
  function hideProductNonVisibleDivs() {
    var i, divId, div;
    for(i = 0; i < divsProducts.length; i++) {
      divId = divsProducts[i];
      divButtonId = divsButtonsProducts[i];
      div = document.getElementById(divId);
      divButtons = document.getElementById(divButtonId);
      if(visibleProductDivId === divId) {
        div.style.display = "block";
        divButtons.classList.add("buttonsActive");
      } else {
        div.style.display = "none";
        divButtons.classList.remove("buttonsActive");
      }
    }
  }

var divsSearch = ["hledatObjednavky", "hledatProdukty", "hledatZakazniky"];
var divsButtonsSearch = ["buttonHledatObjednavky", "buttonHledatProdukty", "buttonHledatZakazniky"];
  var visibleProductDivId = null;
  function divSearchVisibility(divId) {
    if(visibleProductDivId === divId) {
      visibleProductDivId = null;
    } else {
      visibleProductDivId = divId;
    }
    hideSearchNonVisibleDivs();
  }
  function hideSearchNonVisibleDivs() {
    var i, divId, div;
    for(i = 0; i < divsSearch.length; i++) {
      divId = divsSearch[i];
      divButtonId = divsButtonsSearch[i];
      div = document.getElementById(divId);
      divButtons = document.getElementById(divButtonId);
      if(visibleProductDivId === divId) {
        div.style.display = "block";
        divButtons.classList.add("buttonsActive");
      } else {
        div.style.display = "none";
        divButtons.classList.remove("buttonsActive");
      }
    }
  }

var divsOrder = ["polozkyObjednavky", "pridatPolozku", "kompletaceObjednavky"];
var divsButtonsOrder = ["buttonPolozkyObjednavky", "buttonPridatPolozku", "buttonKompletaceObjednavky"];
  var visibleOrderDivId = null;
  function divOrderVisibility(divId) {
    if(visibleOrderDivId === divId) {
      visibleOrderDivId = null;
    } else {
      visibleOrderDivId = divId;
    }
    hideOrderNonVisibleDivs();
  }
  function hideOrderNonVisibleDivs() {
    var i, divId, div;
    for(i = 0; i < divsOrder.length; i++) {
      divId = divsOrder[i];
      divButtonId = divsButtonsOrder[i];
      div = document.getElementById(divId);
      divButtons = document.getElementById(divButtonId);
      if(visibleOrderDivId === divId) {
        div.style.display = "block";
        divButtons.classList.add("buttonsActive");
      } else {
        div.style.display = "none";
        divButtons.classList.remove("buttonsActive");
      }
    }
  }

var divsCustomers = ["hlavniUdajeZakaznik", "objednavky"];
var divsButtonsCustomers = ["buttonHlavniUdajeZakaznik", "buttonObjednavky"];
  var visibleCustomerDivId = null;
  function divCustomerVisibility(divId) {
    if(visibleCustomerDivId === divId) {
      visibleCustomerDivId = null;
    } else {
      visibleCustomerDivId = divId;
    }
    hideCustomerNonVisibleDivs();
  }
  function hideCustomerNonVisibleDivs() {
    var i, divId, div;
    for(i = 0; i < divsCustomers.length; i++) {
      divId = divsCustomers[i];
      divButtonId = divsButtonsCustomers[i];
      div = document.getElementById(divId);
      divButtons = document.getElementById(divButtonId);
      if(visibleCustomerDivId === divId) {
        div.style.display = "block";
        divButtons.classList.add("buttonsActive");
      } else {
        div.style.display = "none";
        divButtons.classList.remove("buttonsActive");
      }
    }
  }

function showCommentField() {
  var x = document.getElementById("commentField");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function showAddProductField() {
  var x = document.getElementById("addProductField");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function showFilterProductField() {
  var x = document.getElementById("filterMain");
  var y = document.getElementById("filterDown");
  var z = document.getElementById("filterUp");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
    z.style.display = "inline-block";
  } else {
    x.style.display = "none";
    y.style.display = "inline-block";
    z.style.display = "none";
  }
}

var t = 1;
function new_link_related()
{
  t++;
  var div1 = document.createElement('div');
  div1.id = t;
  // link to delete extended form elements
  var delLink = '<div style="float:right;margin-right:25%;margin-top:-60px;"><a href="javascript:delIt('+ t +')"><i class="fas fa-trash" style="color:#ff5252;"></i></a></div>';
  div1.innerHTML = document.getElementById('relatedTpl').innerHTML + delLink;
  document.getElementById('related').appendChild(div1);
}
// function to delete the newly added set of elements
function delIt(eleId)
{
  d = document;
  var ele = d.getElementById(eleId);
  var parentEle = d.getElementById('related');
  parentEle.removeChild(ele);
}

var p = 1;
function new_link_photo()
{
  p++;
  var div1 = document.createElement('div');
  div1.id = p;
  // link to delete extended form elements
  var delLink = '<div style="text-align:right;margin-right:65px"><a href="javascript:delItPhoto('+ p +')">Vymaž službu</a></div>';
  div1.innerHTML = document.getElementById('photoTpl').innerHTML + delLink;
  document.getElementById('photo').appendChild(div1);
}
// function to delete the newly added set of elements
function delItPhoto(eleId)
{
  d = document;
  var ele = d.getElementById(eleId);
  var parentEle = d.getElementById('photo');
  parentEle.removeChild(ele);
}

function dropDownFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

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

function toggle(source) {
  checkboxes = document.getElementsByName('checkbox[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}*/