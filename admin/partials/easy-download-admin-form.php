<?php
if((isset($_GET['output'])) && ($_GET['output'] === 'error'))
{
    if((isset($_GET['type'])) && ($_GET['type'] === 'url'))
    {
        $notice = array('wrong', __('The link submitted is not valid !!', 'easy-download'));
    }
}
?>
<div class="wrap">
    <section class="wpdx-wrapper">
        <div class="wpdx-container">
            <div class="wpdx-tabs">
                <?php echo $this->return_plugin_header(); ?>
                <main class="tabs-main">
                    <?php echo $this->return_tabs_menu('tab2'); ?>
                    <section class="tab-section">
                        <?php if(isset($notice)) { ?>
                        <div class="wpdx-notice <?php echo esc_attr($notice[0]); ?>">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo esc_attr($notice[1]); ?></span>
                        </div>
                        <?php } else { ?>
                        <div class="wpdx-notice info">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo _e('In order to create a new download link, simply use the below form and indicate the absolute URL of the file you want to add.', 'easy-download'); ?></span>
                        </div>
                        <?php } ?>
                        <form method="POST">
                            <input type="hidden" name="edw-update-links" value="true" />
                            <?php wp_nonce_field('edw-referer-form', 'edw-referer-links'); ?>
                            <div class="wpdx-form">
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Link', 'easy-download'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <input type="text" id="<?php echo esc_attr($fieldID); ?>" name="_easy_download_links[url]" placeholder="<?php echo _e('Enter link to add in the database', 'easy-download'); ?>" value="<?php if(isset($opts['url'])) { echo sanitize_url($opts['url']); } ?>" autocomplete="OFF" required="required"/>
                                    <small><?php echo _e('Enter the link you want to add into the database (Must be a valid URL).', 'easy-download'); ?></small>
                                </div>
                                <div class="form-footer">
                                    <input type="submit" class="button button-primary button-theme" style="height:45px;" value="<?php _e('Add Link Now', 'easy-download'); ?>">
                                </div>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
        </div>
    </section>
</div>