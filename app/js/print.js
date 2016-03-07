function StudentPrinter() {
    this.table = ".navbar,.sidebar,.page-header";
    this.letter_head;
}

StudentPrinter.prototype.printSingle = function() {

    $(this.table).css({
        "display": "none"
    });
    $("#content-container").css({
        "position": "relative",
        "margin": "auto"
    });

    print();
};

//intantiate class

function startStudentPrint() {
    var _p = new StudentPrinter();
    _p.printSingle();
}