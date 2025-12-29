<?php
if((isset($_GET['output'])) && ($_GET['output'] === 'updated'))
{
    $notice = array('success', __('Your settings have been successfully updated.', 'wpbs'));
}
elseif((isset($_GET['output'])) && ($_GET['output'] === 'error'))
{
    if((isset($_GET['type'])) && ($_GET['type'] === 'stats'))
    {
        $notice = array('wrong', __('An unknown error occured !!', 'wpbs'));
    }
    if((isset($_GET['type'])) && ($_GET['type'] === 'widget'))
    {
        $notice = array('wrong', __('An unknown error occured !!', 'wpbs'));
    }
}
?>
<div class="wrap">
    <section class="wpdx-wrapper">
        <div class="wpdx-container">
            <div class="wpdx-tabs">
                <?php echo self::return_plugin_header(); ?>
                <main class="tabs-main">
                    <?php echo self::return_tabs_menu('tab1'); ?>
                    <section class="tab-section">
                        <?php if(isset($notice)) { ?>
                        <div class="wpdx-notice <?php echo esc_attr($notice[0]); ?>">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo esc_attr($notice[1]); ?></span>
                        </div>
                        <?php } elseif(!isset($opts['stats'])) { ?>
                        <div class="wpdx-notice warning">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo _e('You have not set up your Easy Download options ! In order to do so, please use the below form.', 'easy-download'); ?></span>
                        </div>
                        <?php } else { ?>
                        <div class="wpdx-notice info">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo _e('Your plugin is properly configured ! You can change at anytime your plugin options using the below form.', 'easy-download'); ?></span>
                        </div>
                        <?php } ?>
                        <form method="POST">
                            <input type="hidden" name="edw-update-option" value="true" />
                            <?php wp_nonce_field('edw-referer-form', 'edw-referer-option'); ?>
                            <div class="wpdx-form">
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Download Stats', 'easy-download'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <div class="onoffswitch">
                                        <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_easy_download_options[stats]" class="onoffswitch-checkbox input-stats" <?php if((isset($opts['stats'])) && ($opts['stats'] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                        <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <small><?php echo _e('Do you want to activate the Easy Download features?', 'easy-download'); ?></small>
                                </div>
                                <div id="handler-stats" class="subfield <?php if((isset($opts['stats'])) && ($opts['stats'] === 'on')) { echo 'show'; } ?>">
                                    <div class="field">
                                        <?php $fieldID = uniqid(); ?>
                                        <span class="label"><?php echo _e('Stats Widget', 'easy-download'); ?></span>
                                        <div class="onoffswitch">
                                            <input id="<?php echo esc_attr($fieldID); ?>" type="checkbox" name="_easy_download_options[widget]" class="onoffswitch-checkbox" <?php if((isset($opts['widget'])) && ($opts['widget'] == 'on')) { echo 'checked="checked"';} ?>/>
                                            <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <small><?php echo _e('Do you want to display the download stats on the admin dashboard?', 'easy-download'); ?></small>
                                    </div>
                                </div>
                                <div class="form-footer">
                                    <input type="submit" class="button button-primary button-theme" style="height:45px;" value="<?php _e('Update Settings', 'wpbs'); ?>">
                                </div>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
        </div>
    </section>
</div>