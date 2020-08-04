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
