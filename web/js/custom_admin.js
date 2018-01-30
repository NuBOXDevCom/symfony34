$(document).ready(function () {
  $('.enableDomain').click(function (e) {
    e.preventDefault()
    let id = $(this).attr('id')
    let $this = $(this)
    $this.replaceWith('<i class=\'fa fa-refresh fa-spin loader\'></i>')
    $.ajax({
      url: '/domains/changestatus/' + id + '/1',
      type: 'GET',
      dataType: 'json'
    })
      .done(function (data) {
        if (data.success) {
          $('.loader').replaceWith('<button class=\'btn bg-red-gradient btn-xs disableDomain\' id=\'' + id + '\'>Désactiver</button>')
          $('#inactive' + id).removeClass('label-danger').addClass('label-success').html('Activé')
        } else {
          $('.loader').replaceWith('ERROR 2')
        }
      })
      .error(function () {
        $('.loader').replaceWith('ERROR 1')
      })
  })
  $('.disableDomain').click(function (e) {
    e.preventDefault()
    let $this = $(this)
    let id = $this.attr('id')
    $this.replaceWith('<i class=\'fa fa-refresh fa-spin loader\'></i>')
    $.ajax({
      url: '/domains/changestatus/' + id + '/0',
      type: 'GET',
      dataType: 'json'
    })
      .done(function (data) {
        if (data.success) {
          $('.loader').replaceWith('<button class=\'btn bg-green-gradient btn-xs enableDomain\' id=\'' + id + '\'>Activer</button>')
          $('#active' + id).removeClass('label-success').addClass('label-danger').html('Désactivé')
        } else {
          $('.loader').replaceWith('ERROR 2')
        }
      })
      .error(function () {
        $('.loader').replaceWith('ERROR 1')
      })
  })
  $('.deleteProduct').click(function (e) {
    e.preventDefault()
    let $this = $(this)
    let id = $this.attr('id')
    $.confirm({
      title: 'Confirmation',
      content: 'Etes-vous sur de vouloir supprimer ce produit ?',
      confirmButton: 'Oui',
      cancelButton: 'Annuler',
      columnClass: 'col-md-4 col-md-offset-4',
      icon: 'fa fa-warning',
      theme: 'black',
      backgroundDismiss: false,
      confirm: function () {
        $this.replaceWith('<i class=\'fa fa-refresh fa-spin loader\'></i>')
        $.ajax({
          url: '/products/delete/' + id,
          type: 'GET',
          dataType: 'json'
        })
          .done(function (data) {
            if (data.success) {
              $.alert('Produit Supprimé avec succès !')
              $('tr#' + id).fadeOut('slow')
            } else {
              $('.loader').replaceWith('ERROR 2')
            }
          })
          .error(function () {
            $('.loader').replaceWith('ERROR 1')
          })
      }
    })
  })
})

