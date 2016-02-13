/**
 * enable popovers for tags with .hasPopover class; version 1.0
 * 
 * @revised   April 16, 2013
 * @author    Matthias Fehring, http://www.buschmann23.de
 * @license   GPLv3, http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package Subar Rum
 * @since Subar Rum 1.0
 */

jQuery(function () { jQuery('.hasPopover').popover(); jQuery('.hasPopover').on('click', function(e) {e.preventDefault(); return true;}); });