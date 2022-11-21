function getReport() {
    const request = new XMLHttpRequest()
    const accessToken = localStorage.accessToken
    
    request.onload = function() {
        try {
            const blob = new Blob([request.response])
            const fileURL = URL.createObjectURL(blob)
            const namaFile = `${localStorage.namaSekolah} ${new Date().toDateString()}.xlsx`
            const link = document.createElement("a");
            
            link.href = fileURL;
            link.setAttribute("download", namaFile);
            document.body.appendChild(link);
            link.click();
        } catch (error) {
            console.log(error)
        }
    }
    
    request.open('GET', `${mainURL}siswa/report`)
    request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
    request.responseType = 'arraybuffer';
    request.send()
}