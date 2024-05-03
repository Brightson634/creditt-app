(function ($) {
  "use strict";

  //to keep the current page active
  $(function () {
    for (
      var nk = window.location,
        o = $(".settings-menu a, .menu a")
          .filter(function () {
            return nk.href.includes(this.href);
          })
          .addClass("active")
          .parent()
          .addClass("active");
      ;

    ) {
      // console.log(o)
      if (!o.is("li")) break;
      o = o.parent().addClass("show").parent().addClass("active");
    }
    if (window.location.pathname.includes("setting")) {
      $("#settings").addClass("active");
    }
  });

  //   $('[data-toggle="tooltip"]').tooltip();
})(jQuery);

(function () {
  const date = document.getElementById("year");
  if (date) {
    date.innerText = new Date().getFullYear();
  }
})();
(function () {
  const aTag = document.querySelectorAll("[href='#']");
  for (let i = 0; i < aTag.length; i++) {
    const a = aTag[i];
    a.addEventListener("click", (e) => {
      e.preventDefault();
    });
  }
})();
