jQuery(document).ready(function($) {
  // localized encoded arrays from php
  var cf7_better_ui_loaders = JSON.parse(CF7BetterUIAdmin.loaders)
  var cf7_better_ui_sizes = JSON.parse(CF7BetterUIAdmin.sizes)

  // set registered options
  $('select[name=cf7-better-ui-loader]').val(CF7BetterUIAdmin.loader)
  $('#CF7BetterUIForm .loader-preview').html(
    cf7_better_ui_loaders[CF7BetterUIAdmin.loader].html
  )

  $('select[name=cf7-better-ui-size]').val(CF7BetterUIAdmin.size)
  $('.loader-preview .cf7-better-ui-loader').css(
    'transform',
    `scale(${cf7_better_ui_sizes[CF7BetterUIAdmin.size]})`
  )

  $('#CF7BetterUIStyles').html(cf7BetterUIReturnStyles(CF7BetterUIAdmin.color))

  // make content visible after all settings are set
  $('#CF7BetterUIForm').css('visibility', 'visible')

  // color picker
  var cf7_better_ui_colorpicker_opts = {
    change: function(event, ui) {
      var current_color = ui.color.toString()
      $('#CF7BetterUIStyles').html(cf7BetterUIReturnStyles(current_color))
    }
  }

  $('#CF7BetterUIForm .my-color-field').wpColorPicker(
    cf7_better_ui_colorpicker_opts
  )

  // loader type on change
  $('select[name=cf7-better-ui-loader]').on('change', function(e) {
    $('.loader-preview').html(cf7_better_ui_loaders[this.value].html)
    var size = $('select[name=cf7-better-ui-size]').val()
    $('.loader-preview .cf7-better-ui-loader').css(
      'transform',
      `scale(${cf7_better_ui_sizes[size]})`
    )
  })

  // loader size on change
  $('select[name=cf7-better-ui-size]').on('change', function(e) {
    $('.loader-preview .cf7-better-ui-loader').css(
      'transform',
      `scale(${cf7_better_ui_sizes[this.value]})`
    )
  })

  // form current color styles for each loader
  function cf7BetterUIReturnStyles(color) {
    var style = '<style>'

    Object.keys(cf7_better_ui_loaders).forEach(function(key) {
      style += cf7_better_ui_loaders[key].style.replace(/color_holder/g, color)
    })

    style += '</style>'

    return style
  }
})
