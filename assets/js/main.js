jQuery(document).ready(function($) {
  // localized encoded arrays from php
  var cf7_better_ui_loaders = JSON.parse(CF7BetterUIData.loaders),
    cf7_better_ui_sizes = JSON.parse(CF7BetterUIData.sizes)

  // form styles for loader
  var cf7_better_ui_color = ''
  Object.keys(cf7_better_ui_loaders).forEach(function(key) {
    if (key == CF7BetterUIData.loader)
      cf7_better_ui_color = cf7_better_ui_loaders[key].style.replace(
        /color_holder/g,
        CF7BetterUIData.color
      )
  })

  var cf7_better_ui_styles = `
    <style>
    .cf7-better-ui-loader {
      transform: scale(${cf7_better_ui_sizes[CF7BetterUIData.size]})
    } ${cf7_better_ui_color} </style> `

  $('head').append(cf7_better_ui_styles)

  // change styles for submit button wrapper
  $('div.wpcf7 > form input[type=submit]')
    .closest('p')
    .css({
      marginBottom: 0,
      display: 'flex',
      alignItems: 'center'
    })

  // cf7 form on submit
  $('div.wpcf7 > form').submit(function(e) {
    $('div.wpcf7 .ajax-loader').html(
      cf7_better_ui_loaders[CF7BetterUIData.loader].html
    )
  })
})
