const mainURL = "http://localhost:3000/";
const viewURL = "http://localhost/ppdb-versi-3/";

function includeHTML(path, elementID) {
  const request = new XMLHttpRequest();
  const view = document.getElementById(elementID);

  request.onload = function () {
    if (this.status == 200) {
      view.innerHTML = request.responseText;
    }
  };

  request.open("GET", path);
  request.send();
}

function attachToView(viewID, content) {
  const view = document.getElementById(viewID);
  view.innerHTML = content;
}

function addToView(viewID, content) {
  const view = document.getElementById(viewID);
  view.innerHTML += content;
}

function showView(viewID) {
  const view = document.getElementById(viewID)
  view.style.display = 'block'
}

function hideView(viewID) {
  const view = document.getElementById(viewID)
  view.style.display = 'none'
}

function setInputValue(viewID, content) {
  const view = document.getElementById(viewID);
  view.value = content;
}

function setToImage(viewID, content) {
  const view = document.getElementById(viewID);
  view.src = content;
}

function setLink(viewID, content) {
  const view = document.getElementById(viewID);
  view.href = content;
}

function setIcon(viewID, iconClass) {
  const view = document.getElementById(viewID);
  view.className = iconClass;
}

function getMonthName(monthNumberString) {
  const monthNumber = parseInt(monthNumberString) - 1
  const arrayOfMonth = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  return arrayOfMonth[monthNumber];
}

var getParams = function (searchString) {
  var parse = function (params, pairs) {
    var pair = pairs[0];
    var parts = pair.split("=");
    var key = decodeURIComponent(parts[0]);
    var value = decodeURIComponent(parts.slice(1).join("="));

    // Handle multiple parameters of the same name
    if (typeof params[key] === "undefined") {
      params[key] = value;
    } else {
      params[key] = [].concat(params[key], value);
    }

    return pairs.length == 1 ? params : parse(params, pairs.slice(1));
  };

  // Get rid of leading ?
  return searchString.length == 0
    ? {}
    : parse({}, searchString.substr(1).split("&"));
};
