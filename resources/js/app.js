import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

//Toastr
import toastr from "toastr";
window.toastr = toastr;

// SweetAlert2
import Swal from "sweetalert2";
window.Swal = Swal;
