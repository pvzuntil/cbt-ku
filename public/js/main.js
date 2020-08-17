const __BASE_URL = $("meta[name=__base_url]").attr("content");
window.dataLayer = window.dataLayer || [];

function gtag() {
  dataLayer.push(arguments);
}
gtag("js", new Date());

gtag("config", "UA-104089728-1");

function notify_success(pesan) {
  new PNotify({
    title: "Berhasil",
    text: pesan,
    type: "success",
    history: false,
    delay: 2000,
  });
}

function notify_info(pesan) {
  new PNotify({
    title: "Informasi",
    text: pesan,
    type: "info",
    history: false,
    delay: 2000,
  });
}

function notify_error(pesan) {
  new PNotify({
    title: "Error",
    text: pesan,
    type: "error",
    history: false,
    delay: 2000,
  });
}

const SW = {
  show(opt) {
    return Swal.fire(opt);
  },
  yesno(opt) {
    return this.show({
      ...opt,
      showCancelButton: true,
    });
  },
  loading() {
    return this.show({
      title: "Memperoses ...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      allowEnterKey: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      },
    });
  },
  close() {
    return Swal.close();
  },
  toast(opt) {
    return this.show({
      ...opt,
      toast: true,
      timer: 3000,
      position: "top-right",
      showConfirmButton: false,
    });
  },
};

const init = () => {
  $("#btn-logout-admin").click(() => {
    SW.yesno({
      title: "Peringatan !",
      text: "Apakah anda yakin ingin keluar .?",
      icon: "warning",
    }).then((res) => {
      if (res.value) {
        window.location.href = __BASE_URL + "manager/welcome/logout";
      }
    });
  });

  $("#btn-logout-user").click(() => {
    SW.yesno({
      title: "Peringatan !",
      text: "Apakah anda yakin ingin keluar .?",
      icon: "warning",
    }).then((res) => {
      if (res.value) {
        window.location.href = __BASE_URL + "/welcome/logout";
      }
    });
  });

};

const callBackDatatable = (id) => {
  let tableWrapper = $("" + id + "_wrapper");
  tableWrapper.children(".row").css({
    width: "100%",
  });

  let dataLength = $("" + id + "_length");
  dataLength.find('select').css({
    margin: '0px 10px'
  })
  // console.log(dataLength.find('select'));


  let rowLenght = dataLength.closest(".row");
  rowLenght.css({
    width: "100%",
  });

  let colLength = dataLength.closest(".col-sm-6");
  colLength.css({
    display: "flex",
    justifyContent: "flex-start",
  });

  let dataSearch = $("" + id + "_filter");
  let rowSearch = dataSearch.closest(".row");
  rowSearch.css({
    width: "100%",
  });

  let colSearch = dataSearch.closest(".col-sm-6");
  colSearch.css({
    display: "flex",
    justifyContent: "flex-end",
  });

  // repair pagination
  let paginationWrapper = $("ul.pagination");

  let rowPagination = $("" + id + "_paginate").closest(".row");

  rowPagination.css({
    width: "100%",
  });

  let paginationPrev = $("" + id + "_previous");
  paginationPrev.addClass("page-item");
  paginationPrev.children("a").addClass("page-link");

  let paginationNumber = paginationWrapper.children("li.paginate_button");
  paginationNumber.addClass("page-item");
  paginationNumber.children("a").addClass("page-link");

  let paginationNext = $("" + id + "_next");
  paginationNext.addClass("page-item");
  paginationNext.children("a").addClass("page-link");
};

function magnify(imgID, zoom) {
  var img, glass, w, h, bw;
  img = document.getElementById(imgID);

  /* Create magnifier glass: */
  glass = document.createElement("DIV");
  glass.setAttribute("class", "img-magnifier-glass");

  /* Insert magnifier glass: */
  img.parentElement.insertBefore(glass, img);

  /* Set background properties for the magnifier glass: */
  glass.style.backgroundImage = "url('" + img.src + "')";
  glass.style.backgroundRepeat = "no-repeat";
  glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
  bw = 3;
  w = glass.offsetWidth / 2;
  h = glass.offsetHeight / 2;

  /* Execute a function when someone moves the magnifier glass over the image: */
  glass.addEventListener("mousemove", moveMagnifier);
  img.addEventListener("mousemove", moveMagnifier);

  /*and also for touch screens:*/
  glass.addEventListener("touchmove", moveMagnifier);
  img.addEventListener("touchmove", moveMagnifier);

  glass.addEventListener('mouseleave', (e) => {
    glass.style.display = 'none'
  })

  function moveMagnifier(e) {
    var pos, x, y;
    /* Prevent any other actions that may occur when moving over the image */
    e.preventDefault();
    /* Get the cursor's x and y positions: */
    pos = getCursorPos(e);
    x = pos.x;
    y = pos.y;
    /* Prevent the magnifier glass from being positioned outside the image: */
    if (x > img.width - (w / zoom)) {
      x = img.width - (w / zoom);
    }
    if (x < w / zoom) {
      x = w / zoom;
    }
    if (y > img.height - (h / zoom)) {
      y = img.height - (h / zoom);
    }
    if (y < h / zoom) {
      y = h / zoom;
    }
    /* Set the position of the magnifier glass: */
    glass.style.left = (x - w) + "px";
    glass.style.top = (y - h) + "px";
    /* Display what the magnifier glass "sees": */
    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
    glass.style.display = 'block'
  }

  function getCursorPos(e) {
    var a, x = 0,
      y = 0;
    e = e || window.event;
    /* Get the x and y positions of the image: */
    a = img.getBoundingClientRect();
    /* Calculate the cursor's x and y coordinates, relative to the image: */
    x = e.pageX - a.left;
    y = e.pageY - a.top;
    /* Consider any page scrolling: */
    x = x - window.pageXOffset;
    y = y - window.pageYOffset;
    return {
      x: x,
      y: y
    };
  }
}

$(() => {
  init();

  $.fn.modal.Constructor.prototype._enforceFocus = function () {};

  $('.select2').select2()
});

(function ($) {
  $.fn.serializeToJSON = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
      if (o[this.name]) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || "");
      } else {
        o[this.name] = this.value || "";
      }
    });
    return o;
  };
})(jQuery);