$(document).ready(function () {
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    })
  })
  $('.deleteDomain').click(function (e) {
    e.preventDefault()
    let $this = $(this)
    let id = $this.attr('id')
    $.confirm({
      title: 'Confirmation',
      content: 'Etes-vous sur de vouloir supprimer ce domaine ?',
      confirmButton: 'Oui',
      cancelButton: 'Annuler',
      columnClass: 'col-md-4 col-md-offset-4',
      icon: 'fa fa-warning',
      theme: 'black',
      backgroundDismiss: false,
      confirm: function () {
        $this.replaceWith('<i class=\'fa fa-refresh fa-spin loader\'></i>')
        $.ajax({
          url: '/domains/delete/' + id,
          type: 'GET',
          dataType: 'json'
        })
          .done((data) => {
            if (data.success) {
              $.alert('Domaine Supprimé avec succès !')
              $('tr#' + id).fadeOut('slow')
            } else {
              $('.loader').replaceWith('ERROR 2')
            }
          })
          .error(() => {
            $('.loader').replaceWith('ERROR 1')
          })
      }
    })
  })
})
