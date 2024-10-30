<div class="wrap">
  <h1>Better UI for Contact Form 7</h1>

  <?php 

  // message after settings were updated
  if( isset($_GET['settings-updated']) ) { ?>

  <div id='message' class='updated'>
    <p> <strong><?php _e('Settings saved.') ?></strong> </p>
  </div>

  <?php } ?>

  <div class="desc">
    <?php 
    if (!is_plugin_active('contact-form-7/wp-contact-form-7.php')) { ?>
    <p><b>This plugin requires Contact Form 7 to be installed and activated, otherwise it is useless.</b></p>
    <?php } ?>

    <p>Here you can choose loader style for your contact forms created with Contact Form 7 plugin.</p>

  </div>

  <form id="CF7BetterUIForm" method="post" action="options.php">
    <?php settings_fields( CF7_BETTER_UI_OPTIONS_FIELD_NAME ); ?>

    <div class="form-content">

      <div class="input-group">
        <label>Loader type</label>
        <select name="cf7-better-ui-loader">
          <?php foreach($this->loaders as $key => $loader) { ?>
          <option value="<?php echo $key ?>"><?php echo $key ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="input-group">
        <label>Loader size</label>
        <select name="cf7-better-ui-size">
          <?php foreach($this->sizes as $key => $size) { ?>
          <option value="<?php echo $key ?>"><?php echo $key ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="input-group">
        <label>Loader color</label>
        <input name="cf7-better-ui-color" type="text" value="<?php echo $this->settings['color'] ?>"
          class="my-color-field" />
      </div>

    </div>

    <div class="form__submit">
      <?php submit_button(); ?>
      <div class="loader-preview">
        <div class="cf7-better-ui-loader lds-facebook">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>

    <div id="CF7BetterUIStyles"></div>

  </form>

</div>