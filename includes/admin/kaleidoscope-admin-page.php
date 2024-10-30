<html>
<body>
<div class="wrap">
    <h1>Kaleidoscope Playlist Settings</h1>
    <form method="post" action="options.php">
        <?php settings_fields('kaleidoscope-playlist-settings'); ?>
        <?php do_settings_sections('kaleidoscope-playlist-settings'); ?>
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_api_key">Kaleidoscope Api Key</label>
                </th>
                <td>
                    <input name="kaleidoscope_api_key" type="text" class="regular-text"
                           value="<?php echo get_option('kaleidoscope_api_key'); ?>" required/>
                </td>
            </tr>
            </tbody>
        </table>
        <br/><br/>
        <br/><br/>
        <h1>SlideShow Settings</h1>
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_playlist_width">Width (in px)</label>
                </th>
                <td>
                    <input style="width:100px" name="kaleidoscope_playlist_width" type="number" placeholder="640"
                           value="<?php echo get_option('kaleidoscope_playlist_width'); ?>">
                </td>
                <th scope="row">
                    <label for="kaleidoscope_playlist_height">Height (in px)</label>
                </th>
                <td>
                    <input style="width:100px" name="kaleidoscope_playlist_height" type="number" placeholder="360"
                           value="<?php echo get_option('kaleidoscope_playlist_height'); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_playlist_background_color">Background Color
                </th>
                <td style="padding-top:5px;">
                    <input style="width:100px" name="kaleidoscope_playlist_background_color" type="color"
                    value="<?php echo get_option('kaleidoscope_playlist_background_color'); ?>">
                </td>
                <th scope="row">
                    <label for="kaleidoscope_playlist_background_transparency">Background Transparency (scale 0 to 1)
                </th>
                <td>
                    <input style="width:100px" name="kaleidoscope_playlist_background_transparency" type="range" min="0" max="1" step="0.1"
                    value="<?php echo (get_option('kaleidoscope_playlist_background_transparency')) ? get_option('kaleidoscope_playlist_background_transparency') : '0'; ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                        <label for="kaleidoscope_playlist_border">Preview Border
                </th>
                <td>
                    <div>
                        <p>
                            <select style="min-width:100px" name="kaleidoscope_playlist_border" id="kaleidoscope_playlist_border">
                                <option value="no" <?php echo (get_option('kaleidoscope_playlist_border') == 'no') ? 'selected' : '' ?> > No</option>
                                <option value="yes" <?php echo (get_option('kaleidoscope_playlist_border') == 'yes') ? 'selected' : '' ?> >Yes</option>
                            </select>
                        </p>
                    </div>
                </td>
                <th scope="row">
                    <label for="kaleidoscope_playlist_border_color">Border Color
                </th>
                <td>
                    <input style="width:100px"  name="kaleidoscope_playlist_border_color" type="color"
                    value="<?php echo get_option('kaleidoscope_playlist_border_color'); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_playlist_autoplay">Autoplay</label>
                </th>
                <td>
                    <div>
                    <p>
                        <select style="min-width:100px" name="kaleidoscope_playlist_autoplay" id="kaleidoscope_playlist_autoplay">
                            <option value="true" <?php echo (get_option('kaleidoscope_playlist_autoplay') == 'true') ? 'selected' : '' ?>>Yes</option>
                            <option value="false" <?php echo (get_option('kaleidoscope_playlist_autoplay') == 'false') ? 'selected' : '' ?> >No</option>
                        </select>
                    </p>
                    </div>
                </td>
                <th scope="row">
                    <label for="kaleidoscope_playlist_interval">Interval (in seconds)</label>
                </th>
                <td>
                    <input style="width:100px" name="kaleidoscope_playlist_interval" type="number" required
                    value="<?php echo get_option('kaleidoscope_playlist_interval') ? get_option('kaleidoscope_playlist_interval') : 3 ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_playlist_aniamtion">Animation</label>
                </th>
                <td>
                    <div>
                    <p>
                        <select style="min-width:100px" name="kaleidoscope_playlist_animation" id="kaleidoscope_playlist_animation">
                            <option value="none" <?php echo (get_option('kaleidoscope_playlist_animation') == 'none') ? 'selected' : '' ?> >None</option>
                            <option value="fade" <?php echo (get_option('kaleidoscope_playlist_animation') == 'fade') ? 'selected' : '' ?>>Fade</option>
                            <option value="slide" <?php echo (get_option('kaleidoscope_playlist_animation') == 'slide') ? 'selected' : '' ?>>Slide</option>
                        </select>
                    </p>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_playlist_caption">Preview Caption</label>
                </th>
                <td>
                    <div>
                    <p>
                        <select style="min-width:100px" name="kaleidoscope_playlist_caption" id="kaleidoscope_playlist_caption">
                            <option value="no" <?php echo (get_option('kaleidoscope_playlist_caption') == 'no') ? 'selected' : '' ?> >No</option>
                            <option value="yes" <?php echo (get_option('kaleidoscope_playlist_caption') == 'yes') ? 'selected' : '' ?>>Yes</option>
                        </select>
                    </p>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_playlist_image_fit">Image Fit</label>
                </th>
                <td>
                    <div>
                    <p>
                        <select style="min-width:100px" name="kaleidoscope_playlist_image_fit" id="kaleidoscope_playlist_image_fit">
                            <option value="contain" <?php echo (get_option('kaleidoscope_playlist_image_fit') == 'contain') ? 'selected' : '' ?> >Fit</option>
                            <option value="cover" <?php echo (get_option('kaleidoscope_playlist_image_fit') == 'cover') ? 'selected' : '' ?>>Fill</option>
                            <option value="fill" <?php echo (get_option('kaleidoscope_playlist_image_fit') == 'fill') ? 'selected' : '' ?>>Stretch</option>
                        </select>
                    </p>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="kaleidoscope_playlist_navigation">Navigation Dots</label>
                </th>
                <td>
                    <div>
                    <p>
                        <select style="min-width:100px" name="kaleidoscope_playlist_navigation" id="kaleidoscope_playlist_navigation">
                            <option value="none" <?php echo (get_option('kaleidoscope_playlist_navigation') == 'none') ? 'selected' : '' ?> >Disable</option>
                            <option value="block" <?php echo (get_option('kaleidoscope_playlist_navigation') == 'block') ? 'selected' : '' ?> >Enable</option>
                        </select>
                    </p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <br/><br/><br/><br>
        <h1> Preview Kaleidoscope Playlist</h1>
        <br/>
        <h4>To display Kaleidoscope playlist into WordPress Post/Page, Use below Code</h4>
        <input type="text" class="regular-text" value="[kaleidoscope-playlist]" disabled>
        <br/><br/>
        <?php submit_button(); ?>
    </form>
</div>
</body>
</html>
