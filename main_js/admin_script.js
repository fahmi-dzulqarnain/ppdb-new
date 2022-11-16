/*$(document).ready(function () {
    $("#beranda, #pendaftar, #pengaturan").click(function() {
        $(".disappeared").hide();
    })
    var whichPanel = $(this).attr("id");
		$("." + whichPanel).show();
});*/

beranda = document.querySelector('#beranda');
berandaClick = document.querySelector('#berandaClick')
pendaftar = document.querySelector('#pendaftar');
pendaftarClick = document.querySelector('#pedaftarClick');
pengaturan= document.querySelector('#pengaturan');
pengaturanClick = document.querySelector('#pengaturanClick');

function munculBeranda() {
    beranda.classList.remove('disappeared');
    pendaftar.classList.add('disappeared');
    pengaturan.classList.add('disappeared');

    /*berandaClick.classList.add('side-bar-active');
    pendaftarClick.classList.remove('side-bar-active');
    pengaturanClick.classList.remove('side-bar-active');*/
}

function munculPendaftar() {
    pendaftar.classList.remove('disappeared');
    beranda.classList.add('disappeared');
    pengaturan.classList.add('disappeared');

}

function munculPengaturan() {
    pengaturan.classList.remove('disappeared');
    pendaftar.classList.add('disappeared');
    beranda.classList.add('disappeared');
}


