function isLoaded() {
    var pdfFrame = window.frames["pdf"];
    pdfFrame.focus();
    pdfFrame.print();
}