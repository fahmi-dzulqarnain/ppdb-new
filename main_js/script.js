/* Instantiate single textfield component rendered in the document*/
const textFields = document.querySelectorAll('.mdc-text-field');
for (const textField of textFields) {
mdc.textField.MDCTextField.attachTo(textField);
}

$(document).ready(function () {
    // typing text animation script
    var typed = new Typed(".typing-1", {
        strings: ["TKIT Fajar Ilahi", "SDIT Fajar Ilahi",
            "SMPIT Fajar Ilahi", "SMAIT Fajar Ilahi",
            "Ma'had Khadijah"
        ],
        typeSpeed: 100,
        backSpeed: 60,
        loop: true
    });

    var typed2 = new Typed(".typing-2", {
        strings: ["Pendidikan", "Sosial", "Ekonomi", "Kaderisasi"],
        typeSpeed: 100,
        backSpeed: 60,
        loop: true
    });

    // owl carousel script
    $('.carousel').owlCarousel({
        margin: 10,
        loop: true,
        autoplayTimeOut: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 2,
                nav: false
            },
            1200: {
                items: 3,
                nav: false
            }
        }
    });

    $('.daftar-carousel').owlCarousel({
        margin: 10,
        loop: true,
        autoplayTimeOut: 300,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 2,
                nav: false
            },
            1200: {
                items: 3,
                nav: false
            }
        }
    });

    const closeBtn = document.querySelectorAll('.close-modal')

    function closeModal() {
        const modalContainer = document.getElementById('modal-container')
        modalContainer.classList.remove('show-modal')
    }

    closeBtn.forEach(close => close.addEventListener('click', closeModal))
    
    const closeModalButton = document.querySelectorAll('.close-modal-btn')

    function closeModalBtn() {
        const modalContainer = document.getElementById('modal-announcement-container')
        modalContainer.classList.remove('show-modal')
    }

    closeModalButton.forEach(close => close.addEventListener('click', closeModalBtn))
});

function openModal(schoolName, logo, address, array) {
    const modalContainer = document.getElementById('modal-container')
    modalContainer.classList.add('show-modal')
    var data = array.replace(/@/g, '"')
    data = $.parseJSON(data)
    let keys = Object.keys(data)
    var kontak = ''

    for (let i = 0; i < keys.length; i++) {
        var s = i + 1
        var querySchool = ''
        
        switch (keys[i].replace(/_/g, ' ')) {
            case 'TK A':
                querySchool = data.TK_A.query_name;
                kontak = data.TK_A.kontak;
                break
            case 'TK B':
                querySchool = data.TK_B.query_name;
                kontak = data.TK_B.kontak;
                break
            case 'LK':
                querySchool = data.LK.query_name;
                kontak = data.LK.kontak;
                break
            case 'PR':
                querySchool = data.PR.query_name;
                kontak = data.PR.kontak;
                break
            case 'Idad':
                querySchool = data.Idad.query_name;
                kontak = data.Idad.kontak;
                break
            default:
                querySchool = data.Tarbiyah.query_name;
                kontak = data.Tarbiyah.kontak;
                break
            }

        $(document).on('click', '#modal-btn-' + s, function () {
            window.location.href = "daftar/register.php?unit=" + querySchool + "&type=" + keys[i].replace('_', ' ')
        })

        $("#modal-type-" + s).text(keys[i].replace(/_/g, ' ').replace('LK', 'Ikhwan').replace('PR', 'Akhwat'))
    }

    $("#modal-img").attr("src", 'logo/' + logo)
    $("#modal-title").text(schoolName + ' ' + address)
    $("#modal-contact").text('Kontak : ' + kontak);

    if (schoolName.includes('TK')) {
        $("#modal-capacity").text(data.TK_A.kapasitas + ' Siswa')
        $("#modal-kuota").text(data.TK_A.sisa_kuota + ' / ' + data.TK_A.kuota)
        $("#modal-capacity-2").text(data.TK_B.kapasitas + ' Siswa')
        $("#modal-kuota-2").text(data.TK_B.sisa_kuota + ' / ' + data.TK_B.kuota)
        $("#first").attr("style", 'width: 50%;')
        $("#second").attr("style", 'display: block;')

        $("#modal-description").text('Min. Umur: TK A (4 thn 1 bln), dan TK B (5 thn 1 bln) pada Jul');
    } else if (schoolName.includes('Khadijah')) {
        $("#modal-capacity").text(data.Idad.kapasitas + ' Peserta')
        $("#modal-kuota").text(data.Idad.sisa_kuota + ' / ' + data.Idad.kuota)
        $("#modal-capacity-2").text(data.Tarbiyah.kapasitas + ' Siswa')
        $("#modal-kuota-2").text(data.Tarbiyah.sisa_kuota + ' / ' + data.Tarbiyah.kuota)
        $("#first").attr("style", 'width: 50%;')
        $("#second").attr("style", 'display: block;')
        //$("#first").attr("style", 'width: 100%;')
        //$("#second").attr("style", 'display: none;')

        $("#modal-description").text('')
    } else if (schoolName.includes('SD')) {
        $("#modal-capacity").text(data.LK.kapasitas + ' Siswa')
        $("#modal-kuota").text(data.LK.sisa_kuota + ' / ' + data.LK.kuota)
        $("#modal-capacity-2").text(data.PR.kapasitas + ' Siswa')
        $("#modal-kuota-2").text(data.PR.sisa_kuota + ' / ' + data.PR.kuota)
        $("#first").attr("style", 'width: 50%;')
        $("#second").attr("style", 'display: block;')

        $("#modal-description").text('Min. Umur 6 thn 1 bln pada Jul');
    } else {
        $("#modal-capacity").text(data.LK.kapasitas + ' Siswa')
        $("#modal-kuota").text(data.LK.sisa_kuota + ' / ' + data.LK.kuota)
        $("#modal-capacity-2").text(data.PR.kapasitas + ' Siswa')
        $("#modal-kuota-2").text(data.PR.sisa_kuota + ' / ' + data.PR.kuota)
        $("#first").attr("style", 'width: 50%;')
        $("#second").attr("style", 'display: block;')

        $("#modal-description").text('')
    }
}