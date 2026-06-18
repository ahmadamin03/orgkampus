function showFeature(feature) {
  alert("Membuka menu " + feature);
}

function logout() {
  let konfirmasi = confirm("Apakah Anda yakin ingin logout?");

  if (konfirmasi) {
    alert("Logout berhasil!");
    location.reload();
  }
}

window.onload = function () {
  console.log("Sistem Manajemen Organisasi Kampus Berjalan");
};
