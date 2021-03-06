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
});

function openModal(schoolName, logo, kontak, address, array) {
    const modalContainer = document.getElementById('modal-container')
    modalContainer.classList.add('show-modal')

    var data = array.replace(/@/g, '"')
    data = $.parseJSON(data)
    let keys = Object.keys(data)

    for (let i = 0; i < keys.length; i++) {
        var s = i + 1

        $(document).on('click', '#modal-btn-' + s, function () {
            var querySchool = ''

            switch (keys[i].replace(/_/g, ' ')) {
                case 'TK A':
                    querySchool = data.TK_A.query_name;
                    break
                case 'TK B':
                    querySchool = data.TK_B.query_name;
                    break
                case 'LK':
                    querySchool = data.LK.query_name;
                    break
                case 'PR':
                    querySchool = data.PR.query_name;
                    break
                default:
                    querySchool = data.Mukim_Non_Mukim.query_name;
                    break
            }

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

        $("#modal-description").text('Min. Umur: TK A (4 thn 1 bln), dan TK B (5 thn 1 bln) pada 01 Jul');
    } else if (schoolName.includes('Khadijah')) {
        $("#modal-capacity").text(data.Mukim_Non_Mukim.kapasitas + ' Peserta')
        $("#modal-kuota").text(data.Mukim_Non_Mukim.sisa_kuota + ' / ' + data.Mukim_Non_Mukim.kuota)
        $("#first").attr("style", 'width: 100%;')
        $("#second").attr("style", 'display: none;')

        $("#modal-description").text('Kontak :' + kontak)
    } else if (schoolName.includes('SD')) {
        $("#modal-capacity").text(data.LK.kapasitas + ' Siswa')
        $("#modal-kuota").text(data.LK.sisa_kuota + ' / ' + data.LK.kuota)
        $("#modal-capacity-2").text(data.PR.kapasitas + ' Siswa')
        $("#modal-kuota-2").text(data.PR.sisa_kuota + ' / ' + data.PR.kuota)
        $("#first").attr("style", 'width: 50%;')
        $("#second").attr("style", 'display: block;')

        $("#modal-description").text('Min. Umur: SD (6 thn 1 bln) pada 01 Jul');
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