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
      timer: 2000,
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
        console.log("yaa");
      }
    });
  });
};

$(() => {
  init();
});
