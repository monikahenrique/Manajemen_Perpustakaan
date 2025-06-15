function validateForm() {
    const judul = document.forms["formBuku"]["judul"].value;
    const penulis = document.forms["formBuku"]["penulis"].value;
    if (judul === "" || penulis === "") {
        alert("Judul dan Penulis wajib diisi!");
        return false;
    }
    return true;
}
