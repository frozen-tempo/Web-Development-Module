var collapsed = false;
function collapse() {
  collapsed = !collapsed;
  if (!collapsed) {
    document.getElementById("page-1").style.opacity = "100";
    document.getElementById("page-2").style.opacity = "0";
  } else {
    document.getElementById("page-1").style.opacity = "0";
    document.getElementById("page-2").style.opacity = "100";
  }
}
var male = true;
function changeIcon() {
  male = !male;
  if (male) {
    document.getElementById("male-img").style.opacity = "100";
    document.getElementById("female-img").style.opacity = "0";
  } else {
    document.getElementById("male-img").style.opacity = "0";
    document.getElementById("female-img").style.opacity = "100";
  }
}
