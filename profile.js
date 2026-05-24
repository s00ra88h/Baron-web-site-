document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".order-expanded").forEach(function (el) {
    el.style.overflow   = "hidden";
    el.style.maxHeight  = "0";
    el.style.opacity    = "0";
    el.style.margin     = "0";
    el.style.transition = "max-height 0.35s ease, opacity 0.3s ease";
  });

  document.querySelectorAll(".order-row").forEach(function (row) {
    row.style.cursor = "pointer";
    row.addEventListener("click", function () {
      var id     = row.getAttribute("data-id");
      var exp    = document.getElementById("exp-" + id);
      var isOpen = row.classList.contains("active-order");

      document.querySelectorAll(".order-row").forEach(function (r) {
        r.classList.remove("active-order");
        r.querySelector(".chev").innerHTML = "&gt;";
      });
      document.querySelectorAll(".order-expanded").forEach(function (e) {
        e.style.maxHeight = "0";
        e.style.opacity   = "0";
      });

      if (!isOpen && exp) {
        row.classList.add("active-order");
        row.querySelector(".chev").innerHTML = "&#8963;";
        exp.style.maxHeight = "500px";
        exp.style.opacity   = "1";
      }
    });
  });

  var ordersOpen   = true;
  var ordersHeader = document.getElementById("orders-header");
  var ordersArrow  = document.getElementById("orders-arrow");
  var ordersBody   = document.getElementById("orders-body");

  if (ordersHeader && ordersBody) {
    ordersBody.style.overflow   = "hidden";
    ordersBody.style.maxHeight  = "600px";
    ordersBody.style.transition = "max-height 0.35s ease, opacity 0.3s ease";
    ordersHeader.style.cursor   = "pointer";

    ordersHeader.addEventListener("click", function () {
      ordersOpen = !ordersOpen;
      ordersBody.style.maxHeight = ordersOpen ? "600px" : "0";
      ordersBody.style.opacity   = ordersOpen ? "1"     : "0";
      if (ordersArrow)
        ordersArrow.style.transform = ordersOpen ? "rotate(0deg)" : "rotate(180deg)";
    });
  }

  document.querySelectorAll(".field-group input").forEach(function (input) {
    input.addEventListener("focus", function () {
      input.style.borderColor = "#8B6F5E";
      input.style.outline     = "none";
      input.style.boxShadow   = "0 0 0 2px rgba(139,111,94,0.2)";
    });
    input.addEventListener("blur", function () {
      input.style.borderColor = "";
      input.style.boxShadow   = "";
    });
  });

  var searchBar = document.getElementById("header_search_bar");
  var searchBtn = document.getElementById("search_btn");
  if (searchBar && searchBtn) {
    searchBtn.addEventListener("click", function () {
      if (searchBar.value.trim()) {
        searchBar.style.background = "#f5e6d3";
        setTimeout(function () { searchBar.style.background = ""; }, 600);
      } else {
        searchBar.focus();
      }
    });
    searchBar.addEventListener("keydown", function (e) {
      if (e.key === "Enter") searchBtn.click();
    });
  }

  var avatar = document.getElementById("avatar");
  if (avatar) {
    avatar.style.cursor     = "pointer";
    avatar.style.transition = "transform 0.2s ease";
    avatar.addEventListener("mouseenter", function () { avatar.style.transform = "scale(1.07)"; });
    avatar.addEventListener("mouseleave", function () { avatar.style.transform = "scale(1)"; });
  }

  var backBtn = document.querySelector(".back-btn");
  if (backBtn) {
    backBtn.style.transition = "letter-spacing 0.2s";
    backBtn.addEventListener("mouseenter", function () { backBtn.style.letterSpacing = "0.5px"; });
    backBtn.addEventListener("mouseleave", function () { backBtn.style.letterSpacing = ""; });
  }

});
