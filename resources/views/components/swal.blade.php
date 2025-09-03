<script>
    Livewire.on('alert', function(message) {
        Swal.fire({
            icon: 'success',
            title: "{{ __('OK, perfect!') }}",
            text: message,
            timer: 1500,
            timerProgressBar: true
        });
    });

    Livewire.on('alertFail', function(message) {
        Swal.fire({
            icon: 'info',
            title: "{{ __('Ups!. Something happened. Check your data!') }}",
            text: message,
            timer: 1500,
            timerProgressBar: true
        });
    });

    Livewire.on('confirmConfirmation', function(event) {
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('You won\'t be able to undo this action!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('Yes, confirm!') }}",
            cancelButtonText: "{{ __('Cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('confirm', event);
            }
        });
    });

    Livewire.on('deleteConfirmation', function(event) {
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('You won\'t be able to undo this action!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('Yes, delete!') }}",
            cancelButtonText: "{{ __('Cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('delete', event);
            }
        });
    });
</script>
