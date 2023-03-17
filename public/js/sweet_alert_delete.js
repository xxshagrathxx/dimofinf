$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


                  Swal.fire({
                    title: 'Are you sure ?!!',
                    text: "Remove this record",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#71c016',
                    confirmButtonBorder: '#28a745',
                    cancelButtonColor: '#ff6363',
                    cancelButtonBorder: '#ff5959',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Deleted successfully',
                        'success'
                      )
                    }
                  })


    });

  });
