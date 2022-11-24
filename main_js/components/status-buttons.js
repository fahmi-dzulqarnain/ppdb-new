function activateStatusButtons() {
    const btnLulusPertama = document.getElementById('btnLulusPertama')
    const btnLulus = document.getElementById('btnLulus')
    const btnLulusBersyarat = document.getElementById('btnLulusBersyarat')
    const btnCadangan = document.getElementById('btnCadangan')
    const btnBelumDiterima = document.getElementById('btnBelumDiterima')
    
    btnLulusPertama.onclick = function() {
        changeBulkStatus('Lulus Tes Akademik', selectedCardArray)
    }
    btnLulus.onclick = function() {
        changeBulkStatus('Lulus', selectedCardArray)
    }
    btnLulusBersyarat.onclick = function() {
        changeBulkStatus('Lulus Bersyarat', selectedCardArray)
    }
    btnCadangan.onclick = function() {
        changeBulkStatus('Cadangan', selectedCardArray)
    }
    btnBelumDiterima.onclick = function() {
        changeBulkStatus('Belum Diterima', selectedCardArray)
    }
}