class SweetAlert {
    static init() {

    }
    static success(title, message) {
        const successTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        successTheme.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonText: 'Tutup'
        });
    }

    static error(title, message) {
        const errorTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        errorTheme.fire({
            icon: 'error',
            title: title,
            text: message,
            confirmButtonText: 'Tutup'
        });
    }

    static warning(title, message) {
        const warningTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        warningTheme.fire({
            icon: 'warning',
            title: title,
            text: message,
            confirmButtonText: 'Tutup'
        });
    }

    static info(title, message) {
        const infoTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        infoTheme.fire({
            icon: 'info',
            title: title,
            text: message,
            confirmButtonText: 'Tutup'
        });
    }

    static ask(title, message, callback) {
        const askTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        askTheme.fire({
            icon: 'question',
            title: title,
            text: message,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    static ask(title, message, confirmText, cancelText, callback) {
        const askTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        askTheme.fire({
            icon: 'question',
            title: title,
            text: message,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    static alert(title, message, callback) {
        const askTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        askTheme.fire({
            icon: 'warning',
            title: title,
            text: message,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    static alert(title, message, confirmText, cancelText, callback) {
        const askTheme = Swal.mixin({
            customClass: {
                container: 'sweetalert-background',
                popup: 'rounded border shadow',
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-white',
            },
            buttonsStyling: false,
        });

        askTheme.fire({
            icon: 'warning',
            title: title,
            text: message,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }
}
