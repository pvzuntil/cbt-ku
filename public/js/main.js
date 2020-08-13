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
  $("#btn-logout").click(() => {
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

$(() => {
  init();
});