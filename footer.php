<?php 
/**
 * footer template
 *
 * Displays the footer with it's widgets, provides wp_footer().
 *
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */
?>

      <footer>
        <?php is_page_template( 'page-templates/front-page.php' ) ? get_sidebar( 'front' ) : get_sidebar('footer'); ?>
        <?php if (get_theme_mod('footer_show_copy', 1) || get_theme_mod('footer_show_credits', 1)) get_template_part('info', 'copy'); ?>
      </footer>

    </div> <!-- /container -->
    </div> <!-- /body -->
    
    <?php wp_footer(); ?>

  </body>
</html>